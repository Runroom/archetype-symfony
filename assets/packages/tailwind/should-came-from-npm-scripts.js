module.exports = {
  tailwind: {
    mode: 'jit',
    purge: {
      content: [],
      variables: false
    },
    darkMode: false,
    theme: {
      colors: {},
      screens: {
        's320': '20em',
        's480': '30em',
        's640': '40em',
        's768': '48em',
        's960': '60em',
        'max-s320': { max: '19.9375em' }
      },
      extend: {}
    },
    variants: { extend: {} },
    plugins: []
  }
};
