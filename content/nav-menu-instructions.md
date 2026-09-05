# Añadir "Hacienda y Seguridad Social" al menú principal

El sitio usa el widget **Simple Menu** de Essential Addons for Elementor
dentro de una plantilla de **Header Footer Elementor** (no el menú nativo de
WordPress renderizado por el tema). Esto significa que el menú no
necesariamente se edita en *Apariencia > Menús*: hay que comprobar primero
cuál de las dos vías aplica.

## Opción A — el widget tira de un menú registrado de WordPress

1. En el escritorio de WordPress, ir a **Apariencia > Menús**.
2. Si existe un menú (el que alimenta la cabecera), localizar el elemento
   **"Ámbitos de Especialización"**.
3. Añadir un nuevo elemento de submenú bajo él:
   - **Texto del enlace:** `Hacienda y Seguridad Social`
   - **URL:** `https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/`
4. Colocarlo junto a "Logística y transporte internacional" y "Arte y
   patrimonio" (mismo nivel, incluso orden alfabético o por relevancia).
5. Guardar el menú.

## Opción B — el menú está definido dentro de la plantilla de Elementor

Si en *Apariencia > Menús* no aparece nada o los cambios no se reflejan en la
web:

1. Ir a **Plantillas > Theme Builder** (Elementor) o **Plantillas > Todas las
   plantillas**, y localizar la plantilla de cabecera (la que tiene el ID
   visible en el HTML como `elementor-1928`, según la inspección técnica
   realizada).
2. Editar esa plantilla con Elementor.
3. Localizar el widget **"Simple Menu"** en la cabecera.
4. Ese widget normalmente también tira de un menú de WordPress (comprobar el
   panel de ajustes del widget, campo "Menu") — si es así, aplica la Opción A
   sobre ese menú concreto.
5. Si el menú está escrito a mano dentro del propio widget (menos probable,
   pero posible en instalaciones antiguas), añadir el nuevo elemento
   directamente ahí, siguiendo el mismo texto y URL indicados arriba.
6. Actualizar la plantilla.

## Verificación tras el cambio

- Comprobar en escritorio y en móvil que el nuevo elemento aparece dentro del
  desplegable de "Ámbitos de Especialización".
- Comprobar que el enlace no rompe el hamburger menu móvil (el sitio usa
  `eael-hamburger--responsive`; añadir un elemento más al desplegable no
  debería afectar al comportamiento, pero conviene confirmarlo en un móvil
  real o en las herramientas de desarrollo).
- Confirmar que el enlace apunta a la URL final
  (`/abogado-hacienda-seguridad-social-valencia/`) y no a una URL de
  borrador o distinta.
