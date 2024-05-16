const express = require('express');
const fs = require('fs');
const path = require('path');

const app = express();

// Serve static files like CSS from a directory
app.use(express.static('public'));

// Route to serve HTML files
app.get('/:fileName', (req, res) => {
    const fileName = req.params.fileName;
    const filePath = path.join(__dirname, fileName);

    // Check if the file exists
    fs.access(filePath, fs.constants.F_OK, (err) => {
        if (err) {
            // File does not exist
            res.status(404).send('File not found');
            return;
        }

        // Read the HTML file
        fs.readFile(filePath, 'utf8', (err, html) => {
            if (err) {
                res.status(500).send('Error reading file');
                return;
            }
            res.send(html);
        });
    });
});

app.listen(3000, () => {
    console.log('Server is running on http://localhost:3000');
});
