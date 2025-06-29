-- Удаление категорий без товаров
DELETE FROM categories
WHERE id NOT IN (
  SELECT DISTINCT category_id FROM products
);

-- Удаление продуктов без записей в availabilities
DELETE FROM products
WHERE id NOT IN (
  SELECT DISTINCT product_id FROM availabilities
);

-- Удаление складов без записей в availabilities
DELETE FROM stocks
WHERE id NOT IN (
  SELECT DISTINCT stock_id FROM availabilities
);
