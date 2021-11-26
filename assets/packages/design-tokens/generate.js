const fs = require('fs');
const path = require('path');
const { getColors } = require('.');

const { vars } = getColors();
fs.writeFile(path.join(__dirname, '/../../css/global.css'), vars, err => {
  if (err) throw err;
});
