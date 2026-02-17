# UI Updates - Portrait Product Cards

## Date: 2026-01-31

### 1. ✅ Portrait View for Product Cards
**Changes Implemented:**
- **Aspect Ratio:** Changed product image containers from fixed height (`h-64`, approx square/landscape depending on width) to `aspect-[3/4]`.
- **Locations:**
  1. **Home Page:** Main product grid.
  2. **Product Detail Page:** "You May Also Like" related products section.

**User Experience:**
- Product images now display in a taller, portrait format (3:4 ratio).
- This is ideal for fashion, vertical handicrafts, or tall items.
- Consistent look across the shop.

---
## Files Modified
1. `resources/views/home.blade.php`
2. `resources/views/frontend/products/show.blade.php`
