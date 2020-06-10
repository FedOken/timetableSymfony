module.exports = {
  extends: ['eslint:recommended', 'plugin:react/recommended'],
  parserOptions: {
    ecmaVersion: 6,
    sourceType: 'module',
    ecmaFeatures: {
      jsx: true,
    },
  },
  env: {
    browser: true,
    es6: true,
    node: true,
  },
  parser: 'babel-eslint',
  plugins: ['prettier'],
  rules: {
    'no-console': 0,
    'no-unused-vars': 0,
    'prettier/prettier': 'error',
    'react/prop-types': 0,
  },
}