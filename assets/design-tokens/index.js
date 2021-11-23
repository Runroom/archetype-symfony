const fs = require('fs');
const path = require('path');
const designTokensColors = require('./colors.json');
// const designTokensTypography = require('./typography.json');

const colors = {};

Object.keys(designTokensColors.colors).map(key => {
  const tokens = key.split('_');
  colors[tokens[0]] = {
    ...colors[tokens[0]],
    [tokens[1]]: designTokensColors.colors[key].value
  };
});

// const typography = {
//   mobile: {},
//   desktop: {},
//   fallback: {
//     mobile: {},
//     desktop: {}
//   }
// };

// const getTypographyLabel = key => {
//   const res = key.reduce((container, value, i) => {
//     switch (i) {
//       case 0:
//         return value;
//       case 1:
//         return container + value.toUpperCase();
//       default:
//         return container + value.charAt(0).toUpperCase() + value.slice(1);
//     }
//   }, '');
//   return res;
// };

// const getTypographyName = str => {
//   // TODO: Needs to process typography and fallback dinamically
//   const value = str.toLowerCase();
//   return 'Verdana';
//   // if (value.indexOf('arial') >= 0) {
//   //   return FONT_FALLBACK;
//   // } else if (value.indexOf('caligra') >= 0) {
//   //   return FONT_SECONDARY;
//   // } else {
//   //   return FONT_PRIMARY;
//   // }
// };

// Object.keys(designTokensTypography.typography).map(key => {
//   const tokens = key.split('_');
//   const isFallback = tokens.includes('arial');
//   const device = tokens.shift();
//   const fontFamily = getTypographyName(designTokensTypography.typography[key].fontFamily.value);
//   const fontSize = designTokensTypography.typography[key].fontSize.value.replace('px', '') / 16;
//   const letterSpacing =
//     designTokensTypography.typography[key].letterSpacing.value.replace('px', '') / 16;
//   const styles = `
//     font-family: ${fontFamily};
//     font-size: ${fontSize};
//     font-weight: ${designTokensTypography.typography[key].fontWeight.value};
//     letter-spacing: ${letterSpacing};
//     line-height: ${designTokensTypography.typography[key].lineHeightRelative.value};
//   `;

//   if (isFallback) {
//     tokens.pop();
//     const label = getTypographyLabel(tokens);
//     typography.fallback[device][label] = {
//       key,
//       fontFamily,
//       fontSize,
//       styles
//     };
//   } else {
//     const label = getTypographyLabel(tokens);
//     typography[device][label] = {
//       key,
//       fontFamily,
//       fontSize,
//       styles
//     };
//   }
// });

const createGlobalCSS = () => {
  const filepath = path.join(__dirname, '/../css/global.css');
  const content = `
:root {
    --neutral-100: ${colors.neutral[100]}
}
  `;
  fs.writeFile(filepath, content, err => {
    if (err) throw err;
    console.log('Global CSS File was created successfully.');
  });
};

module.exports = createGlobalCSS;
