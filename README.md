# Laravel Ecommerce Application Documentation

## Overview

This is a complete Laravel ecommerce application with all essential features for online shopping. The application supports both guest and authenticated users, with a robust cart system, order management, and admin panel.

## Features

### Frontend Features
- **Product Listing Page**: Browse products with search, filtering, and pagination
- **Product Details Page**: View detailed product information with images and add to cart
- **Shopping Cart**: Add, remove, and update quantities of products
- **Checkout Process**: Complete order placement with shipping and billing information
- **User Authentication**: Login, register, and password reset functionality
- **Order History**: View past orders and their status

### Backend Features
- **Product Management**: Full CRUD operations for products with image upload
- **Order Management**: View and manage customer orders
- **Inventory Management**: Track product stock levels
- **Payment Processing**: Support for multiple payment methods
- **User Management**: Admin and customer user roles
- **Category Management**: Organize products by categories

## Architecture

### Database Structure

#### Core Tables
1. **users** - User accounts (customers and admins)
2. **categories** - Product categories
3. **products** - Product information with inventory
4. **carts** - Shopping carts (guest and authenticated users)
5. **cart_items** - Individual items in carts
6. **orders** - Customer orders
7. **order_items** - Individual items in orders
8. **payments** - Payment information

### Models and Relationships

#### User Model
- Has many orders
- Has many carts
- Has admin role support

#### Product Model
- Belongs to category
- Has many cart items
- Has many order items
- Includes inventory tracking

#### Cart Model
- Belongs to user (optional for guest users)
- Has many cart items
- Includes cart merging functionality

#### Order Model
- Belongs to user
- Has many order items
- Has one payment
- Includes status tracking

## Cart System

### Guest User Cart
- Guest users can add products to cart using session-based cart_id
- Cart persists across browser sessions
- Cart items are stored in database with session_id

### Authenticated User Cart
- Users have persistent carts linked to their account
- Cart items are stored in database with user_id

### Cart Merging
- When guest users login, their cart is automatically merged with their user cart
- Duplicate products are combined with updated quantities
- Guest cart is deleted after successful merge

### Cart Operations
- Add products to cart
- Update quantities
- Remove products
- Clear entire cart
- View cart total and item count

## Installation and Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL/PostgreSQL database
- Node.js and NPM (for frontend assets)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ecommerce-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   - Update `.env` file with database credentials
   - Run migrations: `php artisan migrate`
   - Seed database: `php artisan db:seed`

6. **Storage setup**
   ```bash
   php artisan storage:link
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

## Default Credentials

### Admin User
- Email: `admin@ecommerce.com`
- Password: `password`

### Sample Customer Users
- Email: `john@example.com`
- Password: `password`

- Email: `jane@example.com`
- Password: `password`

## Usage Guide

### For Customers

#### Browsing Products
1. Visit the home page to see featured products
2. Use the "Products" link to browse all products
3. Use search and filters to find specific products
4. Click on product cards to view details

#### Shopping Cart
1. Add products to cart from product pages
2. View cart by clicking the cart icon in navigation
3. Update quantities or remove items
4. Proceed to checkout when ready

#### Checkout Process
1. Must be logged in to checkout
2. Fill in shipping and billing information
3. Review order summary
4. Place order

#### Order Management
1. View order history in user menu
2. Track order status
3. Cancel orders (if allowed)

### For Administrators

#### Product Management
1. Access admin panel from user menu
2. Create, edit, and delete products
3. Upload product images
4. Manage inventory levels

#### Order Management
1. View all customer orders
2. Update order status
3. View order details
4. Process payments

#### User Management
1. View customer accounts
2. Manage admin users
3. Monitor user activity

## API Endpoints

### Public Routes
- `GET /` - Home page
- `GET /products` - Product listing
- `GET /products/{product}` - Product details
- `GET /categories/{category}` - Category products
- `GET /cart` - Shopping cart
- `POST /cart/add/{product}` - Add to cart
- `PUT /cart/update/{product}` - Update cart item
- `DELETE /cart/remove/{product}` - Remove from cart
- `DELETE /cart/clear` - Clear cart

### Authenticated Routes
- `GET /checkout` - Checkout page
- `POST /checkout` - Place order
- `GET /orders` - User orders
- `GET /orders/{order}` - Order details
- `POST /orders/{order}/cancel` - Cancel order
- `GET /orders/{order}/payment` - Payment page
- `POST /orders/{order}/payment` - Process payment

### Admin Routes
- `GET /admin/products` - Product management
- `POST /admin/products` - Create product
- `PUT /admin/products/{product}` - Update product
- `DELETE /admin/products/{product}` - Delete product
- `GET /admin/orders` - Order management
- `PUT /admin/orders/{order}` - Update order
- `GET /admin/payments` - Payment management

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/           # Authentication controllers
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── HomeController.php
│   │   ├── OrderController.php
│   │   ├── PaymentController.php
│   │   └── ProductController.php
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── MergeGuestCart.php
│   └── Requests/
│       └── Auth/
│           └── LoginRequest.php
├── Models/
│   ├── Cart.php
│   ├── CartItem.php
│   ├── Category.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Payment.php
│   ├── Product.php
│   └── User.php
└── Services/
    └── CartService.php

resources/
└── views/
    ├── auth/               # Authentication views
    ├── cart/
    │   └── index.blade.php
    ├── checkout/
    │   └── index.blade.php
    ├── layouts/
    │   └── app.blade.php
    ├── products/
    │   ├── index.blade.php
    │   └── show.blade.php
    └── home.blade.php

database/
├── migrations/             # Database migrations
└── seeders/               # Database seeders
```

## Customization

### Adding New Features

#### New Product Fields
1. Create migration for new fields
2. Update Product model fillable array
3. Update product forms and views
4. Update validation rules

#### New Payment Methods
1. Add payment method to Payment model
2. Update PaymentController logic
3. Create payment method views
4. Update checkout process

#### New Order Statuses
1. Update Order model status enum
2. Add status-specific logic
3. Update order management views
4. Add status transition rules

### Styling
- Uses Tailwind CSS for styling
- Customize colors in `tailwind.config.js`
- Modify component styles in view files
- Add custom CSS in `resources/css/app.css`

### Database
- All database changes require migrations
- Use seeders for sample data
- Backup database before major changes
- Test migrations in development first

## Security Features

- CSRF protection on all forms
- Input validation and sanitization
- SQL injection prevention
- XSS protection
- Authentication middleware
- Admin role verification
- Secure file uploads

## Performance Optimization

- Database indexing on frequently queried fields
- Eager loading for relationships
- Pagination for large datasets
- Image optimization for product photos
- Caching for static content
- CDN for asset delivery

## Troubleshooting

### Common Issues

#### Cart Not Working
- Check session configuration
- Verify database connections
- Clear application cache
- Check middleware registration

#### Image Upload Issues
- Verify storage link exists
- Check file permissions
- Validate image formats
- Check upload size limits

#### Payment Processing
- Verify payment gateway credentials
- Check webhook configurations
- Validate payment data
- Monitor error logs

### Debug Mode
Enable debug mode in `.env`:
```
APP_DEBUG=true
```

### Logs
Check Laravel logs in `storage/logs/laravel.log`

## Support

For technical support or questions:
1. Check the Laravel documentation
2. Review the code comments
3. Check the error logs
4. Contact the development team

## License

This project is licensed under the MIT License.

---

**Note**: This documentation is for the Laravel ecommerce application. Make sure to keep it updated as the application evolves. 