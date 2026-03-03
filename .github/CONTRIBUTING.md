# Contributing to Magic-ecommerce

Thank you for considering contributing to Magic-ecommerce! Contributions are welcome and greatly appreciated.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How to Report a Bug](#how-to-report-a-bug)
- [How to Request a Feature](#how-to-request-a-feature)
- [How to Submit a Pull Request](#how-to-submit-a-pull-request)
- [Coding Style](#coding-style)

## Code of Conduct

This project adheres to a [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code. Please report unacceptable behavior to [shitaferas195@gmail.com](mailto:shitaferas195@gmail.com).

## Getting Started

1. Fork the repository on GitHub.
2. Clone your fork locally:
   ```bash
   git clone https://github.com/<your-username>/Magic-Ecommerce.git
   cd Magic-Ecommerce
   ```
3. Create a new branch for your changes:
   ```bash
   git checkout -b feature/my-feature
   ```
4. Set up the project following the instructions in the [README](../README.md).

## How to Report a Bug

Before submitting a bug report, please check the [existing issues](https://github.com/ferasshita/Magic-Ecommerce/issues) to avoid duplicates.

When filing a bug report, please use the **Bug Report** issue template and include:

- A clear and descriptive title.
- Steps to reproduce the issue.
- Expected vs. actual behavior.
- Your environment details (PHP version, OS, browser, etc.).
- Any relevant screenshots or error messages.

## How to Request a Feature

Feature requests are welcome! Please use the **Feature Request** issue template and include:

- A clear description of the feature and why it would be useful.
- Any relevant examples or mockups.

## How to Submit a Pull Request

1. Ensure your branch is up to date with `main`:
   ```bash
   git fetch origin
   git rebase origin/main
   ```
2. Make sure your code follows the project's [coding style](#coding-style).
3. Write or update tests for your changes where applicable.
4. Commit your changes with a clear and descriptive message:
   ```bash
   git commit -m "feat: add support for XYZ"
   ```
5. Push your branch to your fork:
   ```bash
   git push origin feature/my-feature
   ```
6. Open a pull request against the `main` branch of this repository and fill in the pull request template.

All pull requests will be reviewed by the maintainers. Constructive feedback may be provided to help improve the quality of the contribution.

## Coding Style

- Follow the existing code style and conventions used throughout the project.
- Use meaningful variable and function names.
- Keep functions small and focused on a single responsibility.
- Add comments where the code logic is not immediately obvious.
- Ensure your changes do not introduce PHP warnings or errors.
