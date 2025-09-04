# Project Folders Structure Blueprint

## Initial Auto-detection Phase

**Project Type Detected:** PHP Web Application with MVC Architecture

**Technology Signatures Found:**
- PHP with Composer dependency management (composer.json)
- PSR-4 autoloading configured for `App\\` namespace
- AltoRouter v2.0 for routing
- Symfony var-dumper v5.0 for debugging
- Bootstrap 5.1 for frontend framework
- Font Awesome 4.7 for icons

**Architecture Classification:**
- **Monolithic Application:** Single cohesive codebase, not a monorepo
- **MVC Pattern:** Clear separation of Models, Views, and Controllers
- **Non-Microservices:** Traditional monolithic web application
- **Frontend Included:** Static assets, CSS, JavaScript, and templated views

## 1. Structural Overview

The Shoes Shop BackOffice is a PHP web application following the **Model-View-Controller (MVC)** architectural pattern with a **Front Controller** design. The project is organized around business domain separation with clear layer boundaries.

**Organizational Principles:**
- **Layer-based organization**: Separation of Controllers, Models, Views, and Utilities
- **Domain-driven structure**: Feature-specific groupings within each layer
- **PSR-4 compliance**: Autoloading follows PHP standards
- **Security-first approach**: Protected directories with .htaccess files
- **Asset separation**: Public resources isolated from application code

**Key Architectural Decisions:**
- Front Controller pattern with single entry point (`public/index.php`)
- Route-based navigation using AltoRouter
- Template-based view rendering (.tpl.php files)
- Database abstraction with Singleton pattern
- Role-based access control (ACL) implementation

## 2. Directory Visualization

```
shoes-shop-backoffice-php/
├── .git/                           # Git version control metadata
├── .gitignore                      # Git ignore rules
├── .vscode/                        # VS Code editor configuration
│   └── settings.json              # Editor settings
├── README.md                       # Project documentation
├── composer.json                   # Composer dependencies and PSR-4 autoloading
├── composer.lock                   # Dependency lock file
├── import-external-repo.sh         # Repository import utility script
├── app/                           # Main application code (PSR-4: App\)
│   ├── .htaccess                  # Apache security rules
│   ├── config.ini.dist            # Configuration template
│   ├── Controllers/               # MVC Controllers layer
│   │   ├── .htaccess             # Directory protection
│   │   ├── CoreController.php    # Base controller with common functionality
│   │   ├── MainController.php    # Homepage controller
│   │   ├── CategoryController.php # Category management
│   │   ├── ProductController.php # Product management
│   │   ├── AppUserController.php # User management
│   │   └── ErrorController.php   # Error handling
│   ├── Models/                    # MVC Models layer (Data/Business Logic)
│   │   ├── .htaccess             # Directory protection
│   │   ├── CoreModel.php         # Base model with common properties
│   │   ├── Category.php          # Category entity and data access
│   │   ├── Product.php           # Product entity and data access
│   │   ├── Brand.php            # Brand entity and data access
│   │   ├── Type.php             # Product type entity
│   │   └── AppUser.php          # User entity and authentication
│   ├── Routes/                    # Route definitions (modular routing)
│   │   ├── CategoryRouter.php    # Category-specific routes
│   │   ├── ProductRouter.php     # Product-specific routes
│   │   └── AppUserRouter.php     # User management routes
│   ├── Utils/                     # Utility classes and helpers
│   │   ├── .htaccess             # Directory protection
│   │   └── Database.php          # Database connection singleton
│   └── views/                     # MVC Views layer (Presentation)
│       ├── .htaccess             # Directory protection
│       ├── layout/               # Layout templates
│       │   ├── header.tpl.php   # Common header template
│       │   └── footer.tpl.php   # Common footer template
│       ├── main/                 # Main/Dashboard views
│       │   └── home.tpl.php     # Homepage template
│       ├── category/             # Category management views
│       ├── product/              # Product management views
│       ├── user/                 # User management views
│       ├── error/                # Error page templates
│       └── partials/             # Reusable view components
├── public/                        # Web server document root
│   ├── .htaccess                 # Apache rewrite rules for Front Controller
│   ├── index.php                 # Front Controller - single entry point
│   ├── sessions/                 # Session data storage
│   └── assets/                   # Static web resources
│       ├── css/                  # Stylesheets
│       │   ├── .keep            # Directory placeholder
│       │   └── style.css        # Custom application styles
│       ├── js/                   # JavaScript files
│       └── images/               # Image assets
├── docs/                          # Project documentation
│   ├── MPD.sql                   # Database schema/migration
│   ├── images.sql                # Sample data
│   ├── routes.md                 # API/Route documentation
│   ├── user_stories.md           # Requirements documentation
│   ├── serveur_de_dev_php.md     # Development server setup
│   └── integration-html-css/     # HTML/CSS integration examples
└── vendor/                        # Composer dependencies (auto-generated)
    └── autoload.php              # Composer autoloader
```

## 3. Key Directory Analysis

### PHP Application Structure

#### **Application Core (`/app`)**

**Purpose**: Contains all application-specific code following PSR-4 autoloading standard.

**Organization Pattern**: Layer-based MVC architecture with domain separation within each layer.

**Security**: Each subdirectory includes `.htaccess` files preventing direct web access.

#### **Controllers Layer (`/app/Controllers`)**
- **CoreController.php**: Base controller providing common functionality (authentication, view rendering, ACL)
- **MainController.php**: Dashboard and homepage logic
- **Domain Controllers**: CategoryController, ProductController, AppUserController for specific business domains
- **ErrorController.php**: Centralized error handling and error page rendering

**Patterns Observed**:
- Inheritance from CoreController for shared functionality
- ACL (Access Control List) implementation for role-based permissions
- Consistent naming convention: [Domain]Controller.php

#### **Models Layer (`/app/Models`)**
- **CoreModel.php**: Base model with common properties (id, timestamps)
- **Entity Models**: Category, Product, Brand, Type, AppUser representing business entities
- **Data Access**: Each model handles its own database operations

**Patterns Observed**:
- Active Record pattern implementation
- Inheritance from CoreModel for shared properties
- Consistent naming: Business entity names in PascalCase

#### **Views Layer (`/app/views`)**
- **Template Organization**: Feature-based folder structure (category/, product/, user/)
- **Layout System**: Shared header/footer templates in layout/
- **Partial Components**: Reusable UI components in partials/
- **Template Extension**: .tpl.php indicating PHP templates

#### **Routing System (`/app/Routes`)**
- **Modular Routing**: Separate router files for different domains
- **Route Registration**: Included in main Front Controller
- **RESTful Patterns**: Following REST conventions for CRUD operations

#### **Utilities (`/app/Utils`)**
- **Database.php**: Singleton pattern for database connection management
- **Shared Services**: Common functionality across the application

### **Public Web Root (`/public`)**

**Purpose**: Web server document root containing only publicly accessible files.

**Security Architecture**: 
- Front Controller pattern with single entry point
- Asset isolation from application logic
- Apache .htaccess rules for URL rewriting

**Directory Structure**:
- **index.php**: Front Controller handling all HTTP requests
- **assets/**: Static resources (CSS, JavaScript, images)
- **sessions/**: PHP session data storage

### **Documentation (`/docs`)**

**Documentation Strategy**:
- **Technical Documentation**: Database schemas, API routes
- **Development Guides**: Server setup, integration examples
- **Business Documentation**: User stories, requirements

### **Development Environment**
- **VS Code Integration**: Workspace settings configured
- **Version Control**: Git with appropriate ignore patterns
- **Dependency Management**: Composer for PHP packages

## 4. File Placement Patterns

### **Configuration Files**
- **Application Config**: `app/config.ini` (environment-specific database settings)
- **Dependency Config**: `composer.json` (project root for dependency management)
- **Web Server Config**: `.htaccess` files (security and routing rules)
- **Editor Config**: `.vscode/settings.json` (development environment)

### **Model/Entity Definitions**
- **Location**: `/app/Models/` directory
- **Naming**: Business entity names in PascalCase (Category.php, Product.php)
- **Inheritance**: All models extend CoreModel.php
- **Pattern**: One class per file, namespace App\Models

### **Business Logic**
- **Controllers**: Domain-specific business logic in `/app/Controllers/`
- **Services**: Utility services in `/app/Utils/` (Database.php)
- **Validation**: Integrated within controller methods
- **Authentication**: Centralized in CoreController base class

### **Interface Definitions**
- **Routing Interfaces**: AltoRouter configuration in `/app/Routes/`
- **Template Interfaces**: View templates in `/app/views/` with .tpl.php extension
- **Database Interface**: PDO abstraction in Utils/Database.php

### **Test Files**
- **Current Status**: No dedicated test directory structure
- **Recommended Pattern**: Would follow `/tests/` directory with mirrored namespace structure

### **Documentation Files**
- **Technical Docs**: `/docs/` directory for all project documentation
- **API Documentation**: routes.md with detailed endpoint specifications
- **Database Schema**: SQL files for structure and sample data
- **Integration Examples**: HTML/CSS examples for frontend development

## 5. Naming and Organization Conventions

### **File Naming Patterns**
- **PHP Classes**: PascalCase (CategoryController.php, CoreModel.php)
- **Template Files**: lowercase with .tpl.php extension (home.tpl.php)
- **Asset Files**: lowercase with hyphens (style.css)
- **Documentation**: lowercase with hyphens (.md extension)

### **Folder Naming Patterns**
- **Application Folders**: PascalCase matching MVC layers (Controllers, Models, Views)
- **Feature Folders**: lowercase matching business domains (category, product, user)
- **Asset Folders**: lowercase descriptive names (css, js, images)

### **Namespace/Module Patterns**
- **Root Namespace**: `App\` mapped to `/app/` directory
- **PSR-4 Compliance**: Namespace structure mirrors directory structure
- **Controller Namespace**: `App\Controllers\`
- **Model Namespace**: `App\Models\`
- **Utility Namespace**: `App\Utils\`

### **Organizational Patterns**
- **Feature Encapsulation**: Related MVC components grouped by business domain
- **Layer Separation**: Clear boundaries between presentation, business logic, and data
- **Security Isolation**: .htaccess files prevent direct access to sensitive directories

## 6. Navigation and Development Workflow

### **Entry Points**
- **Application Entry**: `public/index.php` - Front Controller handling all requests
- **Configuration Start**: `app/config.ini.dist` - Template for environment setup
- **Development Server**: Built-in PHP server targeting public/ directory
- **Database Setup**: `docs/MPD.sql` for schema, `docs/images.sql` for sample data

### **Common Development Tasks**

#### **Adding New Features**
1. **Create Model**: Add new entity class in `/app/Models/`
2. **Create Controller**: Add controller in `/app/Controllers/`
3. **Define Routes**: Add routes in `/app/Routes/` or create new router file
4. **Create Views**: Add templates in `/app/views/[feature]/`
5. **Update Navigation**: Modify header template if needed

#### **Extending Existing Functionality**
1. **Controllers**: Add methods to existing controllers
2. **Models**: Extend entity classes with new properties/methods
3. **Views**: Add new templates or modify existing ones
4. **Routes**: Register new routes in appropriate router files

#### **Adding New Tests**
- **Recommended Location**: Create `/tests/` directory mirroring `/app/` structure
- **Naming Convention**: Match class names with Test suffix
- **Integration**: Use Composer scripts for test running

#### **Configuration Modifications**
- **Database**: Copy `config.ini.dist` to `config.ini` and modify
- **Dependencies**: Add to composer.json and run `composer install`
- **Routes**: Add to appropriate router file in `/app/Routes/`

### **Dependency Patterns**
- **Controller Dependencies**: Inherit from CoreController, use Models
- **Model Dependencies**: Inherit from CoreModel, use Database utility
- **View Dependencies**: Access controller-provided data, include layout templates
- **Import Patterns**: Use statement for namespace resolution, require_once for includes

### **Content Statistics**
- **Controllers**: 6 controller classes (+ 1 base class)
- **Models**: 6 model classes (+ 1 base class) 
- **Router Files**: 3 modular router files
- **View Directories**: 6 feature-based view folders
- **Documentation Files**: 5 technical documentation files

## 7. Build and Output Organization

### **Build Configuration**
- **Dependency Management**: `composer.json` defines autoloading and dependencies
- **Composer Scripts**: `composer install` for dependency installation
- **No Build Process**: Direct PHP execution without compilation
- **Asset Management**: Static file serving from public/assets/

### **Output Structure**
- **Web Root**: `/public/` directory serves as web server document root
- **Application Logic**: Isolated in `/app/` directory (not web accessible)
- **Generated Content**: PHP session files in `/public/sessions/`
- **Vendor Dependencies**: `/vendor/` directory (excluded from version control)

### **Environment-Specific Builds**
- **Development Configuration**: `config.ini.dist` template
- **Production Configuration**: Copy and customize config.ini
- **Development Server**: `php -S 0.0.0.0:8080 -t public` (documented in docs/)
- **Production Deployment**: Apache with .htaccess rules

### **Asset Organization**
- **CSS Files**: `/public/assets/css/` (Bootstrap via CDN + custom style.css)
- **JavaScript**: `/public/assets/js/` (Bootstrap bundle via CDN)
- **Images**: `/public/assets/images/` for application images
- **External Assets**: CDN-based (Bootstrap, Font Awesome) for performance

## 8. PHP-Specific Organization Patterns

### **Composer Integration**
- **PSR-4 Autoloading**: `"App\\": "app/"` mapping
- **Dependency Declaration**: AltoRouter, Symfony var-dumper, benoclock/alto-dispatcher
- **Autoload Generation**: Vendor autoload.php included in Front Controller
- **Version Constraints**: Semantic versioning with caret notation (^5.0, ^2.0)

### **PHP Best Practices Implementation**
- **Namespace Usage**: Full namespace declarations in all classes
- **Type Hinting**: Method parameters and return types specified
- **Visibility Modifiers**: Proper use of public, protected, private
- **Documentation**: PHPDoc blocks for method descriptions

### **MVC Framework Patterns**
- **Front Controller**: Single entry point with routing dispatch
- **Template Engine**: PHP templates with data extraction pattern
- **Database Abstraction**: PDO with singleton pattern
- **Session Management**: PHP sessions with custom storage location

### **Security Implementation**
- **Directory Protection**: .htaccess files in all non-public directories
- **Input Validation**: Planned in controller methods
- **Authentication**: Role-based access control in CoreController
- **Session Security**: Custom session storage location

## 9. Extension and Evolution

### **Extension Points**

#### **Adding New Business Domains**
1. **Create Model**: Follow naming pattern [Domain].php in Models/
2. **Create Controller**: Follow pattern [Domain]Controller.php in Controllers/
3. **Create Router**: Follow pattern [Domain]Router.php in Routes/
4. **Create Views**: Create /views/[domain]/ directory with templates
5. **Update Navigation**: Add menu items to header template

#### **Adding New Features to Existing Domains**
- **Controller Methods**: Add CRUD methods following existing patterns
- **Model Methods**: Extend entity classes with business logic
- **Routes**: Register new endpoints in appropriate router files
- **Templates**: Add view files following .tpl.php naming convention

#### **Plugin/Extension Architecture**
- **Utility Extensions**: Add classes to Utils/ namespace
- **Middleware Pattern**: Extend CoreController for cross-cutting concerns
- **Template Extensions**: Use partials/ directory for reusable components

### **Scalability Patterns**
- **Feature Modules**: Group related MVC components by business domain
- **Service Layer**: Utils/ directory for shared business services  
- **View Components**: Partials system for UI component reuse
- **Route Organization**: Modular routing files prevent monolithic route definitions

### **Refactoring Patterns**
- **Controller Extraction**: Move business logic from controllers to service classes
- **Model Splitting**: Separate data access from business entities
- **Template Inheritance**: Use layout system for consistent UI structure
- **Configuration Management**: Environment-specific config files

## 10. Structure Templates

### **New Feature Template**
```
/app/Models/[Domain].php                    # Business entity
/app/Controllers/[Domain]Controller.php     # Business logic
/app/Routes/[Domain]Router.php              # Route definitions
/app/views/[domain]/                        # View templates directory
├── list.tpl.php                           # List view
├── add-update.tpl.php                      # Form view  
└── detail.tpl.php                         # Detail view
```

### **New Controller Template**
```php
<?php
namespace App\Controllers;

class [Domain]Controller extends CoreController
{
    public function list()
    {
        // List entities
        $this->show('[domain]/list');
    }
    
    public function add()
    {
        // Show add form
        $this->show('[domain]/add-update');
    }
    
    public function create()
    {
        // Process form submission
    }
    
    public function edit($id)
    {
        // Show edit form
        $this->show('[domain]/add-update');
    }
    
    public function update($id)
    {
        // Process update
    }
    
    public function delete($id)
    {
        // Delete entity
    }
}
```

### **New Model Template**
```php
<?php
namespace App\Models;

class [Domain] extends CoreModel
{
    protected $property1;
    protected $property2;
    
    // Getters and setters
    public function getProperty1()
    {
        return $this->property1;
    }
    
    public function setProperty1($value)
    {
        $this->property1 = $value;
    }
    
    // Static methods for data access
    public static function find($id)
    {
        // Implementation
    }
    
    public static function findAll()
    {
        // Implementation
    }
}
```

### **New Router Template**
```php
<?php

// List route
$router->map(
    'GET',
    '/[domain]/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\[Domain]Controller'
    ],
    '[domain]-list'
);

// Add form route
$router->map(
    'GET', 
    '/[domain]/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\[Domain]Controller'
    ],
    '[domain]-add'
);

// CRUD routes following RESTful patterns...
```

### **New View Template Structure**
```
/app/views/[domain]/
├── list.tpl.php              # Entity listing template
├── add-update.tpl.php        # Form template (add/edit)
├── detail.tpl.php            # Single entity view
└── partials/                 # Domain-specific partials
    └── [domain]-card.tpl.php # Reusable component
```

## 11. Structure Enforcement

### **Structure Validation**
- **Composer Validation**: `composer validate` checks composer.json
- **PSR-4 Compliance**: Autoloader enforces namespace/directory mapping
- **Apache Rules**: .htaccess files enforce directory access restrictions
- **Git Ignore**: Prevents committing vendor/ and config files

### **Development Guidelines**
- **Naming Conventions**: Consistent PascalCase for classes, lowercase for features
- **Directory Organization**: Follow MVC layer separation
- **File Placement**: Respect namespace/directory structure mapping
- **Template Structure**: Use .tpl.php extension and layout inheritance

### **Documentation Practices**
- **Route Documentation**: Maintain routes.md with endpoint specifications  
- **Code Documentation**: PHPDoc blocks for class and method documentation
- **Setup Documentation**: Clear installation and configuration instructions
- **Architecture Documentation**: This blueprint document serves as structural reference

### **Quality Assurance**
- **Directory Security**: .htaccess files prevent unauthorized access
- **Dependency Management**: Composer lock file ensures consistent dependencies
- **Version Control**: Proper .gitignore excludes build artifacts and sensitive files
- **Configuration Management**: Template-based config with environment separation

---

## Blueprint Maintenance

This blueprint document reflects the project structure as of the current analysis. It should be updated when:

- New business domains are added to the application
- Architectural patterns change or evolve  
- New development tools or frameworks are integrated
- Directory structure or file organization is refactored
- New development guidelines or conventions are established

**Last Updated**: Generated during project analysis - should be maintained as project evolves
**Version**: 1.0 - Initial comprehensive structure documentation