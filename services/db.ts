import { 
  collection, 
  getDocs, 
  getDoc, 
  doc, 
  addDoc, 
  updateDoc, 
  deleteDoc, 
  query, 
  where,
  Timestamp,
  orderBy
} from 'firebase/firestore';
import { db, auth } from '../lib/firebase.js';

export enum OperationType {
  CREATE = 'create',
  UPDATE = 'update',
  DELETE = 'delete',
  LIST = 'list',
  GET = 'get',
  WRITE = 'write',
}

export interface FirestoreErrorInfo {
  error: string;
  operationType: OperationType;
  path: string | null;
  authInfo: {
    userId?: string | null;
    email?: string | null;
    emailVerified?: boolean | null;
    isAnonymous?: boolean | null;
    tenantId?: string | null;
    providerInfo?: {
      providerId?: string | null;
      email?: string | null;
    }[];
  }
}

function handleFirestoreError(error: unknown, operationType: OperationType, path: string | null) {
  const errInfo: FirestoreErrorInfo = {
    error: error instanceof Error ? error.message : String(error),
    authInfo: {
      userId: auth.currentUser?.uid,
      email: auth.currentUser?.email,
      emailVerified: auth.currentUser?.emailVerified,
      isAnonymous: auth.currentUser?.isAnonymous,
      tenantId: auth.currentUser?.tenantId,
      providerInfo: auth.currentUser?.providerData?.map(provider => ({
        providerId: provider.providerId,
        email: provider.email,
      })) || []
    },
    operationType,
    path
  }
  console.error('Firestore Error: ', JSON.stringify(errInfo));
  throw new Error(JSON.stringify(errInfo));
}

export async function getProducts() {
  const path = 'products';
  try {
    const q = query(collection(db, path), orderBy('createdAt', 'desc'));
    const snapshot = await getDocs(q);
    return snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
  } catch (error) {
    handleFirestoreError(error, OperationType.LIST, path);
    return [];
  }
}

export async function getProductById(id: string) {
  const path = `products/${id}`;
  try {
    const docRef = doc(db, 'products', id);
    const snapshot = await getDoc(docRef);
    if (snapshot.exists()) {
      return { id: snapshot.id, ...snapshot.data() };
    }
    return null;
  } catch (error) {
    handleFirestoreError(error, OperationType.GET, path);
    return null;
  }
}

export async function seedProducts() {
  const products = [
    { 
      name: "BRUTAL TEE", 
      price: 675000, 
      category: "T-SHIRT", 
      image: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&q=80", 
      images: [
        "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80",
        "https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80",
        "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80"
      ],
      stock: { S: 10, M: 15, L: 5, XL: 2 }, 
      createdAt: Timestamp.now() 
    },
    { 
      name: "VOID CAPSULE", 
      price: 1800000, 
      category: "ACCESSORIES", 
      image: "https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400&q=80", 
      images: [
        "https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=800&q=80",
        "https://images.unsplash.com/photo-1544816153-12ad5d714b21?w=800&q=80",
        "https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80"
      ],
      stock: { S: 0, M: 5, L: 5, XL: 0 }, 
      createdAt: Timestamp.now() 
    },
    // ... adding more if needed
  ];

  // (I'll just add the rest in same pattern)
  const moreProducts = [
    { name: "LOOT BAG", price: 1275000, category: "ACCESSORIES", image: "https://images.unsplash.com/photo-1544816153-12ad5d714b21?w=400&q=80", images: ["https://images.unsplash.com/photo-1544816153-12ad5d714b21?w=800&q=80", "https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=800&q=80", "https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80"], stock: { S: 0, M: 0, L: 0, XL: 0 }, createdAt: Timestamp.now() },
    { name: "RAW DENIM", price: 2850000, category: "PANTS", image: "https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&q=80", images: ["https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80", "https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80", "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80"], stock: { S: 5, M: 8, L: 10, XL: 4 }, createdAt: Timestamp.now() },
    { name: "VOID HOODIE", price: 1425000, category: "T-SHIRT", image: "https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&q=80", images: ["https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80", "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80", "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80"], stock: { S: 12, M: 12, L: 12, XL: 12 }, createdAt: Timestamp.now() },
    { name: "TECH JACKET", price: 3150000, category: "OUTERWEAR", image: "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400&q=80", images: ["https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80", "https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80", "https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80"], stock: { S: 3, M: 3, L: 3, XL: 3 }, createdAt: Timestamp.now() },
  ];

  for (const p of [...products, ...moreProducts]) {
    await addDoc(collection(db, 'products'), p);
  }
  console.log("Seeded database with initial products.");
}
