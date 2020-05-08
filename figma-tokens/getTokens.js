import fs from 'fs';
import fetch from 'node-fetch'
import getColors from './types/getColors';
import getTypography from './types/getTypography';
import getSpacing from './types/getSpacing';
import getBreakpoints from './types/getBreakpoints';

import settings from '../designtokens.config.json';

const emojis = {
  color: '🎨',
  typography: '🖋 ',
  spacing: '📐',
  breakpoint: '🍪',
}

const genFile = (name, tokens, outDir) =>
  fs.writeFile(
    `${outDir}/${name}.json`,
    JSON.stringify(tokens, null, 2),
    err => {
      if (err) {
        throw new Error(`\x1b[31m\n\n❌ ${err}\n\n`)
      }
      // eslint-disable-next-line no-console
      console.log(
        `\x1b[32m ${
        emojis[name]
        } ${name.toUpperCase()} tokens created!\x1b[0m\n`
      )
    }
  )

const genTokens = (apikey, id, outDir) => {
  // eslint-disable-next-line no-console
  console.log('\x1b[40m Connecting with Figma... \x1b[0m\n')
  const FETCH_URL = `https://api.figma.com/v1/files/${id}`
  const FETCH_DATA = {
    method: 'GET',
    headers: {
      'X-Figma-Token': apikey
    }
  }

  try {
    fetch(FETCH_URL, FETCH_DATA)
      .then(response => {
        // eslint-disable-next-line no-console
        console.log(
          ' Connection with Figma is successful...\n\n----------------\n'
        )
        return response.json()
      })
      .then(styles => {
        if (styles.status !== 403 && styles.status !== 404) {
          const figmaTree = styles.document.children.filter(page => page.name === settings.pageName);
          if (figmaTree.length === 0) throw new Error(`There is no page called: ${settings.pageName}`);

          genFile('color', getColors('Colors', figmaTree[0]), outDir)
          genFile('spacing', getSpacing('Spacings', figmaTree[0]), outDir)
          genFile('typography', getTypography('Typography', figmaTree[0]), outDir)
          genFile(
            'breakpoint',
            getBreakpoints('Breakpoints', figmaTree[0]),
            outDir
          )
        }
      })
      .catch(err => {
        throw new Error(`\x1b[31m\n\n❌ ${err}\n\n`)
      })
  } catch (err) {
    throw new Error(`\x1b[31m\n\n❌ ${err}\n\n`)
  }
}

export default genTokens
