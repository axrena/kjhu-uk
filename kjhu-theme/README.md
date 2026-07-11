# Kjhu Theme - Pterodactyl Panel Theme

Dark Purple Gradient Design inspired by Arix Theme.

![Preview](preview.png)

## Features

- 🌙 **Dark Mode Default** - Modern dark purple gradient design
- 📱 **Responsive** - Works on all devices
- 🎨 **Customizable** - Easy to modify colors and styles
- ⚡ **Lightweight** - Minimal performance impact
- 🔧 **Easy Installation** - Simple setup process

## Requirements

- Pterodactyl Panel v1.x
- PHP 8.1+
- Node.js 18+ (for rebuilding)
- Yarn or NPM

## Installation

### Method 1: Manual Installation

1. **Upload Theme Files**

   Upload the theme folder contents to your Pterodactyl panel:

   ```
   /var/www/pterodactyl/
   ├── resources/
   │   └── views/
   │       └── layouts/
   │           ├── admin.blade.php
   │           └── user.blade.php
   └── public/
       └── kjhu-theme/
           ├── css/
           ├── js/
           └── images/
   ```

2. **Configure Layouts**

   Edit `resources/views/layouts/admin.blade.php`:
   
   Replace the content with the theme's admin layout.

3. **Rebuild Assets**

   ```bash
   cd /var/www/pterodactyl
   
   # Install dependencies
   yarn install
   
   # Build for production
   yarn build:production
   ```

4. **Clear Cache**

   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

### Method 2: Using Composer

```bash
cd /var/www/pterodactyl

# Require the theme package (if available as a package)
composer require kjhu/theme

# Publish assets
php artisan vendor:publish --tag=kjhu-theme --force
```

## Configuration

### Custom Colors

Edit `public/kjhu-theme/css/main.css` and modify the CSS variables:

```css
:root {
    /* Primary Colors */
    --kjhu-primary: #8B5CF6;
    --kjhu-primary-dark: #7C3AED;
    --kjhu-primary-light: #A78BFA;
    
    /* Secondary Colors */
    --kjhu-secondary: #EC4899;
    
    /* Background Colors */
    --kjhu-bg-dark: #0F0F1A;
    --kjhu-bg-darker: #080810;
    --kjhu-bg-card: #1A1A2E;
    
    /* ... more variables */
}
```

### Custom Logo

Replace `public/kjhu-theme/images/logo.png` with your logo.

### Custom Favicon

Replace `public/kjhu-theme/images/favicon.png` with your favicon (32x32 or 64x64 recommended).

## File Structure

```
kjhu-theme/
├── css/
│   ├── main.css          # Main theme styles
│   └── login.css         # Login page styles
├── js/
│   └── main.js           # Theme JavaScript
├── views/
│   ├── layouts/
│   │   ├── admin.blade.php    # Admin panel layout
│   │   └── user.blade.php      # User/client layout
│   ├── partials/
│   │   └── server-card.blade.php
│   └── dashboard.blade.php
└── assets/
    └── images/
        ├── logo.png
        └── favicon.png
```

## Custom Components

### Server Card

```blade
@include('kjhu::partials.server-card', [
    'name' => 'My Server',
    'status' => 'online',
    'node' => 'Node 1',
    'ram' => 4096,
    'disk' => 10240,
    'cpu' => 25
])
```

### Alert

```blade
<div class="alert alert-primary">
    Your message here
</div>
```

Available alert types:
- `alert-primary` - Purple gradient
- `alert-success` - Green
- `alert-warning` - Yellow
- `alert-danger` - Red

## Troubleshooting

### Theme not showing?

1. Clear cache: `php artisan view:clear`
2. Check file permissions: `chmod -R 755 public/kjhu-theme`
3. Verify layout files are in correct location

### Styles not loading?

1. Check browser console for 404 errors
2. Verify asset paths in layout files
3. Rebuild assets: `yarn build:production`

### JS not working?

1. Check browser console for errors
2. Verify jQuery/Bootstrap are loaded
3. Clear browser cache

## Support

For support, please open an issue on the repository.

## License

This theme is licensed under the MIT License.

## Credits

- Design inspired by [Arix Theme](https://builtbybit.com/resources/arix-theme-latest-pterodactyl.36705/)
- Built for Pterodactyl Panel
