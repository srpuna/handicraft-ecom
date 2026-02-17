# Feature Updates - Maintenance, Zoom, Search

## Date: 2026-01-31

### 1. ✅ Maintenance Mode (Password Protected)
**Features:**
- **Global Protection:** Blocks public access when enabled, showing a branded "Under Maintenance" page.
- **Admin Access:** Admins and Login pages remain accessible.
- **Toggle Control:** Located in Admin Dashboard > System Status.
- **Security:** Requires Admin Password confirmation to enable/disable.
- **Implementation:** Middleware based (`CheckMaintenanceMode`), using Cache storage.

### 2. ✅ Product Image Zoom
**Features:**
- **Hover Zoom:** Hovering over the main product image on the details page magnifies it.
- **Lens Effect:** The zoom follows the mouse cursor, allowing inspection of details.
- **Scale:** Set to 2.5x to provide a "100% size" feel (high detail).
- **UX:** Cursor changes to `zoom-in` for affordance.

### 3. ✅ Search & Filtering
**Frontend:**
- **Header Search:** The search bar in the simplified header is now functional.
- **Results:** Searches product Name, Short Description, and Long Description on the Home/Shop page.

**Admin Dashboard:**
- **Product List Filter:** Added a filter bar above the product table.
- **Capabilities:**
  - Search by Name or SKU.
  - Filter by Category.
- **Clear:** "Clear" button appears when filters are active.

---
## Files Modified
1. `app/Http/Middleware/CheckMaintenanceMode.php` (New)
2. `bootstrap/app.php` (Register Middleware)
3. `resources/views/maintenance.blade.php` (New View)
4. `routes/web.php` (Maintenance Route)
5. `app/Http/Controllers/Admin/DashboardController.php` (Toggle Logic)
6. `resources/views/admin/dashboard.blade.php` (Toggle UI)
7. `resources/views/frontend/products/show.blade.php` (Zoom)
8. `resources/views/layouts/app.blade.php` (Header Search)
9. `app/Http/Controllers/Frontend/HomeController.php` (Search Logic)
10. `resources/views/admin/products/index.blade.php` (Admin Filter UI)
11. `app/Http/Controllers/Admin/ProductController.php` (Admin Filter Logic)
