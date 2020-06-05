import fs from "file-system";
import getTokens from "./getTokens";
const path = "./designtokens.config.json";
// allow other config file

export function cli() {
  fs.access(path, fs.F_OK, (err) => {
    if (err) {
      console.error("❌");
      console.error("\x1b[31m Config file was not found!");
      console.error(
        "\x1b[31m Please, create a `figma.config.json` with a config parameters"
      );
      return;
    }
    fs.readFile(path, "utf8", (err, data) => {
      if (err) throw err;
      const { FIGMA_APIKEY, FIGMA_ID, FIGMA_OUTDIR } = JSON.parse(data);
      if (!FIGMA_APIKEY) {
        return console.log("❌ No Figma API Key found");
      } else if (!FIGMA_ID) {
        return console.log("❌ No Figma ID found");
      } else {
        if (!FIGMA_OUTDIR) {
          console.log("⚠️ No outdir found, default outdir is `tokens`");
        }
        fs.mkdir(`${FIGMA_OUTDIR}`, null, (err) => {
          if (err) throw err;
          getTokens(FIGMA_APIKEY, FIGMA_ID, FIGMA_OUTDIR);
        });
      }
    });
  });
}
