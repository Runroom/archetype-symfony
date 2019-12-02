# Modular Scale

Hasta la fecha veníamos utilizando una dependencia que nos creaba una función `ms()` en Sass para generar la escala modular apartir de un `ratio`, pero esta solución [no nos permitía mayor versatilidad](https://www.npmjs.com/package/modularscale-sass#multiple-scale-threads), a pesar que la descripción del plugin indicaba que si.

Al utilizar la opción que nos indicaba el plugin, obteníamos un error en el que indicaba que no se podía utilizar la función `ms()` con parámetros indicados con _keyword_.

Hemos eliminado este plugin y creado la función que nos permita realizarlo. Dejo unos links de implementación:

- [@function ms](assets/scss/tools/_functions.scss)
- [Codepen](https://codepen.io/italodr/pen/ZEEdgOw)

La función necesita tener configurada la variable `$msBase`, la cuál está configurada por defecto en `assets/scss/settings/variables/_typography.scss`. En este mismo archivo hay una configuración de ejemplo para un ratio distinto en Desktop.

## Ejemplo de uso

```
/* Teniendo en cuenta la siguiente configuración */
$msBase: 1.2 !default;
$msDesktop: 1.5;

/* Nuestro componente puede utilizarlo de la siguiente manera */
.sample-title {
    font-size: ms(3);

    @include breakpoint($s1024) {
        font-size: ms(3, $msDesktop);
    }
}
```
