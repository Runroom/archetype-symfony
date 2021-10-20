/*
 * For a detailed explanation regarding each configuration property, visit:
 * https://jestjs.io/docs/configuration
 */

module.exports = {
  clearMocks: true,
  testMatch: ['<rootDir>/tests/Frontend/*/*.test.js'], // How to find our tests.
  transform: { '\\.[jt]sx?$': 'babel-jest' },
  setupFilesAfterEnv: ['<rootDir>/tests/Frontend/config/jest-setup.js'],
  testEnvironment: 'jsdom'
};
