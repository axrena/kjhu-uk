#!/bin/bash

# ============================================
# Kjhu Theme - Pterodactyl Panel Installer
# Dark Purple Gradient Design
# ============================================

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Banner
echo -e "${BLUE}"
echo "╔═══════════════════════════════════════════╗"
echo "║                                           ║"
echo "║         Kjhu Theme Installer               ║"
echo "║         Dark Purple Gradient              ║"
echo "║                                           ║"
echo "╚═══════════════════════════════════════════╝"
echo -e "${NC}"

# Check if running as root
if [ "$EUID" -eq 0 ]; then
    echo -e "${YELLOW}Warning: Running as root. This is not recommended.${NC}"
fi

# Get panel path
read -p "Enter your Pterodactyl panel path [/var/www/pterodactyl]: " PANEL_PATH
PANEL_PATH=${PANEL_PATH:-/var/www/pterodactyl}

# Validate path
if [ ! -d "$PANEL_PATH" ]; then
    echo -e "${RED}Error: Directory $PANEL_PATH does not exist.${NC}"
    exit 1
fi

if [ ! -f "$PANEL_PATH/artisan" ]; then
    echo -e "${RED}Error: Pterodactyl installation not found at $PANEL_PATH${NC}"
    exit 1
fi

echo -e "${GREEN}Installing Kjhu Theme...${NC}"

# Create theme directory
THEME_DIR="$PANEL_PATH/public/kjhu-theme"
mkdir -p "$THEME_DIR/css" "$THEME_DIR/js" "$THEME_DIR/images"

# Copy files
echo -e "${YELLOW}Copying theme files...${NC}"

# CSS
cp -r css/* "$THEME_DIR/css/" 2>/dev/null || true
cp -r js/* "$THEME_DIR/js/" 2>/dev/null || true

# Create placeholder logo
if [ ! -f "$THEME_DIR/images/logo.png" ]; then
    echo -e "${YELLOW}Note: Please upload your logo to $THEME_DIR/images/logo.png${NC}"
fi

if [ ! -f "$THEME_DIR/images/favicon.png" ]; then
    echo -e "${YELLOW}Note: Please upload your favicon to $THEME_DIR/images/favicon.png${NC}"
fi

# Copy views
VIEW_DIR="$PANEL_PATH/resources/views"
if [ -d "$VIEW_DIR/layouts" ]; then
    # Backup original layouts
    if [ ! -f "$VIEW_DIR/layouts/admin.blade.php.bak" ]; then
        cp "$VIEW_DIR/layouts/admin.blade.php" "$VIEW_DIR/layouts/admin.blade.php.bak"
        echo -e "${GREEN}Backed up original admin.blade.php${NC}"
    fi
    
    if [ ! -f "$VIEW_DIR/layouts/user.blade.php.bak" ]; then
        cp "$VIEW_DIR/layouts/user.blade.php" "$VIEW_DIR/layouts/user.blade.php.bak" 2>/dev/null || true
    fi
    
    # Copy theme layouts
    cp views/layouts/admin.blade.php "$VIEW_DIR/layouts/admin.blade.php" 2>/dev/null || true
    cp views/layouts/user.blade.php "$VIEW_DIR/layouts/user.blade.php" 2>/dev/null || true
fi

# Set permissions
echo -e "${YELLOW}Setting permissions...${NC}"
chmod -R 755 "$THEME_DIR"

# Clear cache
echo -e "${YELLOW}Clearing cache...${NC}"
cd "$PANEL_PATH"
php artisan view:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Build assets
echo -e "${YELLOW}Building assets...${NC}"
if command -v yarn &> /dev/null; then
    yarn install 2>/dev/null || true
    yarn build:production 2>/dev/null || true
elif command -v npm &> /dev/null; then
    npm install 2>/dev/null || true
    npm run production 2>/dev/null || true
fi

echo ""
echo -e "${GREEN}╔═══════════════════════════════════════════╗"
echo -e "${GREEN}║                                           ║"
echo -e "${GREEN}║         Installation Complete!           ║"
echo -e "${GREEN}║                                           ║"
echo -e "${GREEN}╚═══════════════════════════════════════════╝${NC}"
echo ""
echo -e "${BLUE}Next steps:${NC}"
echo "1. Upload your logo to: $THEME_DIR/images/logo.png"
echo "2. Upload your favicon to: $THEME_DIR/images/favicon.png"
echo "3. Customize colors in: $THEME_DIR/css/main.css"
echo "4. Clear cache: php artisan cache:clear"
echo "5. Rebuild assets if needed"
echo ""
echo -e "${YELLOW}Don't forget to backup your original layouts!${NC}"
echo ""
