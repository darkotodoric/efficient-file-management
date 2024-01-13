# Efficient File Management

![Packagist License](https://img.shields.io/packagist/l/darkotodoric/efficient-file-management)
![Packagist Version](https://img.shields.io/packagist/v/darkotodoric/efficient-file-management)

The `EfficientFileManagement` class is a highly efficient PHP solution for managing and storing an extensive number of
files, potentially in the order of billions, while maintaining exceptional performance. It achieves this scalability by
organizing files into a hierarchical folder structure based on unique IDs (from database or any other source) and file
extensions.

## Installation

Install the latest version with:

```bash
$ composer require darkotodoric/efficient-file-management
```

## Usage

```php
require_once 'vendor/autoload.php';

// Define the folder path where files will be saved
$baseFolderPath = '/mnt/efficient-file-management/';

// Define allowed extensions
$allowedExtensions = ['json', 'xml', 'txt'];

// Define the division number (Maximum number of files in one folder)
$divisionNumber = 50000;

$efficientFileManagement = new EfficientFileManagement($baseFolderPath, $allowedExtensions, $divisionNumber);

// Get IDs from MySQL or other data source
$ids = [1337, 5162, 70312, 155312, 160312, 525312];

// Save content
foreach ($ids as $id) {
    $data = json_encode(['name' => 'File with ID ' . $id]);
    $efficientFileManagement->saveContent($id, 'json', $data);
}

// Get content
foreach($ids as $id){
    $data = $efficientFileManagement->getContent($id, 'json');
}

// Delete content
foreach($ids as $id){
    $data = json_encode(['name' => 'File with ID ' . $id]);
    $efficientFileManagement->deleteContent($id, 'json');
}
```

## Folder and file structures

Here's an example of how the folder structure and files might look when using the `EfficientFileManagement` class to
store files
with IDs and extensions:
Suppose we have the following files:

- File with ID `123456`, `987654`, `555555` and extension `json`
- File with ID `987654` and extension `xml`
- File with ID `555555` and extension `txt`

The resulting folder structure might look like this:

```
/mnt/efficient-file-management/
    ├── json/
    │   ├── 2/
    │   │   └── 123456.json
    │   ├── 19/
    │   │   └── 987654.json
    │   ├── 11/
    │   │   └── 555555.json
    ├── xml/
    │   ├── 19/
    │   │   └── 987654.xml
    ├── txt/
    │   ├── 11/
    │   │   └── 555555.txt
```

In this structure:

- Files with the `.json` extension are stored in the `json` folder.
- Files with the `.xml` extension are stored in the `xml` folder.
- Files with the `.txt` extension are stored in the `txt` folder.
- Each folder is further organized into subfolders based on the integer division of the file's ID by 50000. This
  hierarchical organization ensures that even with a vast number of files, the system remains efficient and easily
  manageable.

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests to improve this project.
