# PRAETORIA — Embudo Hacienda y Seguridad Social

Diagnóstico guiado en 5 pasos para personas que han recibido notificaciones de la AEAT, TGSS o INSS, con resumen estructurado por WhatsApp/email, contenido SEO, datos estructurados y diseño responsive. El formulario no almacena datos ni sube documentos: genera localmente un mensaje que el usuario decide enviar por WhatsApp o correo.

Este repositorio contiene dos cosas:

## 1. Vista previa temporal (GitHub Pages) — retirada del índice

`index.html` / `app.js` / `styles.css` — desplegado automáticamente en:

`https://farinosv44.github.io/hacienda-/`

Fue la vista previa temporal mientras no existía versión definitiva. Ahora que
la página oficial está publicada y verificada en `praetoriaabogados.es`, esta
copia está marcada `noindex,follow`, con el canonical apuntando a la URL
definitiva y un aviso visible enlazando a ella, para no competir por
posicionamiento con la página real. Se mantiene solo como referencia/demo
técnica, no como contenido a indexar.

## 2. Plugin de WordPress (integración definitiva) — en producción

`wordpress-plugin/praetoria-hacienda-funnel/` — plugin ligero y autónomo que
expone el mismo embudo mediante el shortcode `[praetoria_hacienda_funnel]`,
con la identidad real de PRAETORIA (sitio en WordPress + Astra + Elementor,
rojo `#C10000`, tipografía Roboto, botones píldora). Publicado y verificado
en producción en:

`https://praetoriaabogados.es/abogado-hacienda-y-seguridad-social-en-valencia/`

El instalable versionado se publica como ZIP en
[GitHub Releases](https://github.com/FarinosV44/hacienda-/releases).

Todo el CSS y JS del plugin está delimitado bajo `.phf-funnel` para no
interferir con el tema ni con otros plugins. Ver **`INSTALL.md`** para el
procedimiento completo de instalación, pruebas, SEO, enlaces internos y
verificación, y `content/` para las piezas de contenido (metadatos SEO,
artículos del clúster de contenido, plan de enlaces internos, instrucciones
de menú).

## Validación rápida

- **Vista previa GitHub Pages:** abrir `index.html` en un servidor estático y
  recorrer las cuatro ramas del diagnóstico.
- **Plugin de WordPress:** abrir
  `wordpress-plugin/praetoria-hacienda-funnel/tests/preview.html` (sirviendo
  desde la carpeta del plugin para que las rutas relativas a `assets/`
  funcionen) — es un espejo estático exacto de lo que devuelve el shortcode,
  usado para probar el diseño y la lógica del embudo sin necesidad de una
  instalación de WordPress.

Ninguno de los dos necesita compilación ni dependencias.
