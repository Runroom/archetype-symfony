const designTokensColors = require('./colors.json');
// const designTokensTypography = require('./typography.json');

const getColors = () => {
  const data = {};
  const tailwind = {};
  let vars = ':root {';

  Object.keys(designTokensColors.colors).map(key => {
    if (key === 'empty_name') return;

    const tokens = key.split('_');
    const variant = tokens.pop();
    const name = tokens.join('-');
    const result = [tokens[0]];
    tokens.slice(1).forEach(w => result.push(w.replace(/./, m => m.toUpperCase())));
    const camelizedName = result.join('');
    const cssVarName = `--${name}-${variant}`;
    const cssVarValue = designTokensColors.colors[key].value;

    vars = vars + ` ${cssVarName}: ${cssVarValue};`;
    tailwind[`${camelizedName}${variant}`] = `var(${cssVarName})`;

    data[camelizedName] = {
      ...data[camelizedName],
      [variant]: cssVarValue
    };
  });

  vars = vars + ' }';

  return {
    data,
    tailwind,
    vars
  };
};

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

const getTailwindColors = () => {
  const { tailwind } = getColors();
  return { colors: tailwind };
};

module.exports = {
  getColors,
  getTailwindColors
};
