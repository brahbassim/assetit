# Contributing

Thank you for considering contributing to AssetIT! This document outlines the process for contributing to the project.

## Ways to Contribute

- 🐛 **Report Bugs**: Create an issue with detailed steps to reproduce
- 💡 **Suggest Features**: Open an issue with feature description
- 📖 **Improve Documentation**: Fix typos, add examples, clarify sections
- 🔧 **Submit Pull Requests**: Implement features or fix bugs
- 🎨 **Improve UI/UX**: Design improvements, accessibility fixes

## Development Workflow

### 1. Fork the Repository

Click the "Fork" button on GitHub to create your own copy.

### 2. Clone Your Fork

```bash
git clone https://github.com/your-username/assetit.git
cd assetit
```

### 3. Create a Feature Branch

```bash
git checkout -b feature/amazing-feature
# or
git checkout -b fix/bug-description
```

### 4. Make Changes

Implement your feature or fix, following the coding standards.

### 5. Write Tests

Add tests for new features or bug fixes.

### 6. Commit Changes

```bash
git add .
git commit -m 'Add amazing feature'
```

### 7. Push to GitHub

```bash
git push origin feature/amazing-feature
```

### 8. Create Pull Request

Open a PR on GitHub with:
- Clear title and description
- Link to related issues
- Screenshots for UI changes

## Coding Standards

### PHP

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding style
- Use meaningful variable and function names
- Add PHPDoc comments for classes and methods
- Keep methods small and focused

### Blade Templates

- Use semantic HTML
- Follow Bootstrap conventions
- Add accessibility attributes

### JavaScript

- Use vanilla JS or follow Vue/React patterns
- Keep functions small and modular

## Testing

### Run Tests

```bash
php artisan test
# or
./vendor/bin/phpunit
```

### Create Tests

```bash
# Feature test
php artisan make:test HardwareAssetFeatureTest

# Unit test
php artisan make:test --unit HardwareAssetTest
```

## Commit Messages

- Use imperative mood: "Add feature" not "Added feature"
- Keep first line under 72 characters
- Reference issues: "Fixes #123"

Example:

```
Add license expiration alert feature

- Add scheduled command to check expiring licenses
- Add email notification for admins
- Update license model with days_until_expiration accessor
- Add tests for expiration check

Closes #45
```

## Documentation

- Update README.md for user-facing changes
- Add docblocks to new methods
- Update this CONTRIBUTING.md if process changes

## Questions?

- Open a discussion on GitHub
- Check existing issues and discussions
- Review the documentation

## Recognition

Contributors will be added to the README.md Hall of Fame section.

Thank you for your contribution! 🎉
