import express from 'express';
import path from 'path';
import { fileURLToPath } from 'url';
import fs from 'fs';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = 3000;

// Simple "Blade-like" renderer for the preview environment
app.engine('blade.php', (filePath, options, callback) => {
  fs.readFile(filePath, (err, content) => {
    if (err) return callback(err);
    
    let rendered = content.toString();
    
    // Very basic regex to handle common Blade tags for the preview
    // This is NOT a full Blade engine, just enough to show the UI
    rendered = rendered.replace(/@yield\('content'\)/g, options.content || '');
    rendered = rendered.replace(/@include\('(.+?)'\)/g, (match, p1) => {
        const partialPath = path.join(__dirname, 'resources/views', p1.replace(/\./g, '/') + '.blade.php');
        return fs.existsSync(partialPath) ? fs.readFileSync(partialPath, 'utf8') : `[Missing Partial: ${p1}]`;
    });
    rendered = rendered.replace(/@extends\('(.+?)'\)/g, ''); // Handled by the route
    
    // Handle @vite
    rendered = rendered.replace(/@vite\(\[(.+?)\]\)/g, () => {
        return `<link rel="stylesheet" href="/resources/css/app.css">
                <script type="module" src="/resources/js/app.js"></script>`;
    });

    rendered = rendered.replace(/\{\{\s*(.+?)\s*\}\}/g, (match, p1) => {
        if (p1.includes('request()->is')) return 'false';
        if (p1.includes('formatPrice')) return 'Rp ???';
        return options[p1] || '';
    });
    rendered = rendered.replace(/@foreach(.+?)@endforeach/gs, '[List of Items]');
    rendered = rendered.replace(/@if(.+?)@endif/gs, '');

    // If it's a child view, we need to wrap it in the layout
    if (content.toString().includes("@extends('layout')")) {
        const layoutPath = path.join(__dirname, 'resources/views/layout.blade.php');
        const layoutContent = fs.readFileSync(layoutPath, 'utf8');
        // Simple recursive render for the layout
        const fullContent = layoutContent.replace(/@yield\('content'\)/, rendered);
        // Clean up tags in layout
        const final = fullContent.replace(/@include\('(.+?)'\)/g, (match, p1) => {
            const partialPath = path.join(__dirname, 'resources/views', p1.replace(/\./g, '/') + '.blade.php');
            return fs.existsSync(partialPath) ? fs.readFileSync(partialPath, 'utf8') : `[Missing Partial: ${p1}]`;
        });
        return callback(null, final);
    }

    return callback(null, rendered);
  });
});

app.set('views', './resources/views');
app.set('view engine', 'blade.php');

app.use(express.static('public'));
app.use('/resources', express.static('resources'));

// Mock data for the preview
const mockProducts = [
    { id: 1, name: "BRUTAL TEE", price: 675000, category: "T-SHIRT" },
    { id: 2, name: "VOID CAPSULE", price: 1800000, category: "ACCESSORIES" }
];

app.get('/', (req, res) => {
    res.render('pages/home', { products: mockProducts });
});

app.get('/products', (req, res) => {
    res.render('pages/products', { products: mockProducts, categories: ['ALL', 'T-SHIRT'], searchQuery: '', activeCategory: 'ALL' });
});

app.listen(PORT, '0.0.0.0', () => {
    console.log(`Preview server running on http://0.0.0.0:${PORT}`);
    console.log(`NOTE: This Node server is a PREVIEW SHIM ONLY. Use PHP for production.`);
});
