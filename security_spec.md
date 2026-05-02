# Security Specification

## Data Invariants
1. A user can only modify their own profile (username/email). Roles are immutable for non-admins.
2. Products are public for reading but only admins can create/update/delete.
3. Carts are isolated to the specific user.
4. Orders are isolated to the specific user. Only admins can update order status.
5. All IDs must follow a strict pattern to prevent poisoning.

## The Dirty Dozen Payloads

1. **Identity Spoofing**: Attempt to create a user profile for someone else.
2. **Privilege Escalation**: Attempt to create a user with `role: 'admin'`.
3. **Ghost Field Injection**: Adding `isVerified: true` to a product.
4. **ID Poisoning**: Using a 2KB string as a product ID.
5. **PII Leak**: Non-admin reading another user's email.
6. **Denial of Wallet**: Large array of images in product (1000 items).
7. **Cross-User Cart Write**: User A adds item to User B's cart.
8. **Negative Price**: Creating a product with price `-500`.
9. **Invalid Category**: Product with category `FRESH_FRUIT` (not in whitelist if enforced).
10. **State Shortcut**: User updating order status to `completed`.
11. **Shadow Update**: Updating product `createdAt` timestamp.
12. **Orphaned Order Item**: Creating an order item without a valid order parent (not applicable in flat but logic-wise).

## Test Runner (Logic Overview)
Tests will be run using the Firebase Emulator or simulated logic to ensure:
- `PERMISSION_DENIED` for all Dirty Dozen.
- `ALLOW` for valid operations.
