import knex from 'knex';
import config from './knexfile.js';

const db = knex(config);

async function init() {
  try {
    console.log('Initializing local SQL database (SQLite)...');

    // Drop tables if they exist (for a fresh start in this dev env)
    await db.schema.dropTableIfExists('order_items');
    await db.schema.dropTableIfExists('orders');
    await db.schema.dropTableIfExists('cart_items');
    await db.schema.dropTableIfExists('carts');
    await db.schema.dropTableIfExists('product_size_stock');
    await db.schema.dropTableIfExists('product_images');
    await db.schema.dropTableIfExists('sizes');
    await db.schema.dropTableIfExists('products');
    await db.schema.dropTableIfExists('users');

    // 1. Products
    await db.schema.createTable('products', table => {
      table.increments('id').primary();
      table.string('name').notNullable();
      table.decimal('price', 15, 0).notNullable();
      table.string('category').notNullable();
      table.timestamps(true, true);
    });

    // 2. Product Images
    await db.schema.createTable('product_images', table => {
      table.increments('id').primary();
      table.integer('product_id').unsigned().references('id').inTable('products').onDelete('CASCADE');
      table.string('image_path').notNullable();
      table.timestamps(true, true);
    });

    // 3. Sizes
    await db.schema.createTable('sizes', table => {
      table.increments('id').primary();
      table.string('name').notNullable(); // S, M, L, XL
    });

    // 4. Product Size Stock
    await db.schema.createTable('product_size_stock', table => {
      table.increments('id').primary();
      table.integer('product_id').unsigned().references('id').inTable('products').onDelete('CASCADE');
      table.integer('size_id').unsigned().references('id').inTable('sizes').onDelete('CASCADE');
      table.integer('stock').defaultTo(0);
      table.timestamps(true, true);
    });

    // 5. Users
    await db.schema.createTable('users', table => {
      table.increments('id').primary();
      table.string('username').unique().notNullable();
      table.string('email').unique().notNullable();
      table.string('password').notNullable();
      table.string('role').defaultTo('customer');
      table.timestamps(true, true);
    });

    // 6. Carts
    await db.schema.createTable('carts', table => {
      table.increments('id').primary();
      table.integer('user_id').unsigned().references('id').inTable('users').onDelete('CASCADE');
      table.timestamps(true, true);
    });

    await db.schema.createTable('cart_items', table => {
      table.increments('id').primary();
      table.integer('cart_id').unsigned().references('id').inTable('carts').onDelete('CASCADE');
      table.integer('product_id').unsigned().references('id').inTable('products').onDelete('CASCADE');
      table.integer('size_id').unsigned().references('id').inTable('sizes').onDelete('CASCADE');
      table.integer('quantity').defaultTo(1);
      table.timestamps(true, true);
    });

    // 7. Orders
    await db.schema.createTable('orders', table => {
      table.increments('id').primary();
      table.integer('user_id').unsigned().references('id').inTable('users').onDelete('CASCADE');
      table.decimal('total_price', 15, 0).notNullable();
      table.string('status').defaultTo('pending');
      table.timestamps(true, true);
    });

    await db.schema.createTable('order_items', table => {
      table.increments('id').primary();
      table.integer('order_id').unsigned().references('id').inTable('orders').onDelete('CASCADE');
      table.integer('product_id').unsigned().references('id').inTable('products').onDelete('CASCADE');
      table.integer('size_id').unsigned().references('id').inTable('sizes').onDelete('CASCADE');
      table.integer('quantity').notNullable();
      table.decimal('price', 15, 0).notNullable();
      table.timestamps(true, true);
    });

    // SEED DATA
    console.log('Seeding data...');

    // Seeds
    const sizeIds = await db('sizes').insert([
      { name: 'S' },
      { name: 'M' },
      { name: 'L' },
      { name: 'XL' }
    ]).returning('id');

    const products = [
      { name: "BRUTAL TEE", price: 675000, category: "T-SHIRT" },
      { name: "VOID CAPSULE", price: 1800000, category: "ACCESSORIES" },
      { name: "LOOT BAG", price: 1275000, category: "ACCESSORIES" },
      { name: "RAW DENIM", price: 2850000, category: "PANTS" },
      { name: "VOID HOODIE", price: 1425000, category: "T-SHIRT" },
      { name: "TECH JACKET", price: 3150000, category: "OUTERWEAR" }
    ];

    for (const p of products) {
      const result = await db('products').insert(p).returning('id');
      const productId = typeof result[0] === 'object' ? result[0].id : result[0];
      
      // Images (using placeholders for now as in the original app)
      await db('product_images').insert([
        { product_id: productId, image_path: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&q=80" },
        { product_id: productId, image_path: "https://images.unsplash.com/photo-1549463778-3098f41d24ba?w=400&q=80" },
        { product_id: productId, image_path: "https://images.unsplash.com/photo-1544816153-12ad5d714b21?w=400&q=80" }
      ]);

      // Stock
      for (let i = 1; i <= 4; i++) {
        await db('product_size_stock').insert({
          product_id: productId,
          size_id: i,
          stock: Math.floor(Math.random() * 20) + 5
        });
      }
    }

    // Admin User
    await db('users').insert({
      username: 'admin',
      email: 'admin@vault.io',
      password: 'hashed_password_here',
      role: 'admin'
    });

    console.log('Database initialized successfully.');
  } catch (error) {
    console.error('Error initializing database:', error);
  } finally {
    await db.destroy();
  }
}

init();
