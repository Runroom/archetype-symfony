export const parameters = {
  server: {
    url: 'https://localhost:8443/_storybook'
  },
  controls: {
    expanded: true,
    controls: {
      matchers: {
        color: /(background|color)$/i,
        date: /Date$/
      }
    }
  }
};
