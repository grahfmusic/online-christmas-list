# Christmas Invitation Management Tool
## Version 0.1

Welcome to the **Christmas Invitation Management Tool**! This web application is designed to help manage the guest list for our upcoming holiday celebration. It provides an intuitive interface to add, edit, and organize guest information efficiently.

![screenshot](scnshot.png?raw=true "screenshot")

## Table of Contents

- [Features](#features)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
  - [Viewing Guest Lists](#viewing-guest-lists)
  - [Adding a New Guest](#adding-a-new-guest)
  - [Editing Guest Details](#editing-guest-details)
  - [Sorting the Lists](#sorting-the-lists)
  - [Deleting a Guest](#deleting-a-guest)
  - [Saving Changes](#saving-changes)
  - [Undoing Actions](#undoing-actions)
  - [Exporting the Guest List](#exporting-the-guest-list)
- [Security](#security)
- [Contributing](#contributing)
- [License](#license)
- [Acknowledgments](#acknowledgments)

## Features

- **Guest Management**: Add, edit, and remove guests from the attending or not attending lists.
- **Sorting**: Sort guests by name or company.
- **Data Persistence**: Guest data is securely saved and loaded from the server.
- **Export Options**: Export the guest list as a PDF or Excel spreadsheet.
- **Undo Functionality**: Undo the most recent action.
- **Responsive Design**: Optimized for both desktop and mobile devices.

## Getting Started

These instructions will help you set up and run the project on your local machine for development and testing purposes.

### Prerequisites

- **Web Server**: Apache, Nginx, or any web server capable of running PHP scripts.
- **PHP**: Version 5.3.0 or higher with OpenSSL extension enabled.
- **Browser**: A modern web browser (Google Chrome, Mozilla Firefox, Microsoft Edge).

### Installation

1. **Clone the repository:**

   ```bash
   https://github.com/grahfmusic/online-christmas-list.git
   ```

2. **Navigate to the project directory:**

   ```bash
   cd christmas-invitation-tool
   ```

3. **Set up the web server:**

   - Place the project files (`index.html`, `save_guest_list.php`, `load_guest_list.php`) in the web server's root directory or a virtual host directory.

4. **Set file permissions:**

   - Ensure the server has write permissions to create and modify the `guest_list.dat` file.

   ```bash
   chmod 660 guest_list.dat
   ```

5. **Configure the encryption key:**

   - Open `save_guest_list.php` and `load_guest_list.php`.
   - Replace `'your-secret-key'` with a strong, secure key.
   - **Important**: Keep this key confidential and do not expose it publicly.

## Usage

### Viewing Guest Lists

- The main interface displays two lists:
  - **Attending**: Guests who have confirmed their attendance.
  - **Not Attending**: Guests who are not attending.

### Adding a New Guest

- **To the Attending List:**
  1. Click **"Add Attendee"**.
  2. Enter the guest's name.
  3. The guest will appear in the **Attending** list.

- **To the Not Attending List:**
  1. Click **"Add Not Attending"**.
  2. Enter the guest's name.
  3. The guest will appear in the **Not Attending** list.

### Editing Guest Details

1. Click the checkbox next to the guest's name to enter edit mode.
2. Edit the **Name**, **Company**, and **Comments** fields.
3. Uncheck the checkbox to save changes.

### Sorting the Lists

- Click **"Sort by Name"** or **"Sort by Company"** to sort the list accordingly.

### Deleting a Guest

- Click the **"Delete"** button next to the guest's entry.

### Saving Changes

- Click **"Save List"** to save all changes to the server.

### Undoing Actions

- Click **"Undo"** to reverse the most recent action.

### Exporting the Guest List

- **As PDF**: Click **"Save as PDF"** to download a PDF version.
- **As Spreadsheet**: Click **"Save as Spreadsheet"** to download an Excel file.

## Security

- **Data Encryption**: Guest data is encrypted on the server using AES-256-CBC encryption.
- **Secure Key Management**: The encryption key should be stored securely and not exposed publicly.
- **HTTPS Recommended**: Use HTTPS to encrypt data transmission between the client and server.

## Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository.
2. Create a new branch:

   ```bash
   git checkout -b feature/your-feature-name
   ```

3. Commit your changes:

   ```bash
   git commit -m "Add your message"
   ```

4. Push to the branch:

   ```bash
   git push origin feature/your-feature-name
   ```

5. Open a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- **Front-End Libraries**:
  - [jsPDF](https://github.com/parallax/jsPDF)
  - [jsPDF-AutoTable](https://github.com/simonbengtsson/jsPDF-AutoTable)
  - [SheetJS (XLSX)](https://github.com/SheetJS/sheetjs)
- **Fonts**:
  - [Overpass](https://fonts.google.com/specimen/Overpass)
  - [Ubuntu Mono](https://fonts.google.com/specimen/Ubuntu+Mono)

---

**Note:** Replace `https://github.com/grahfmusic/online-christmas-list.git` with the actual URL of your GitHub repository.

Feel free to copy this content into a `README.md` file and include it in your GitHub project.
