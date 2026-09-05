# PRAETORIA — Embudo Hacienda y Seguridad Social

Landing estática de captación para personas que han recibido notificaciones de la AEAT, TGSS o INSS. Incluye diagnóstico guiado, resumen estructurado por WhatsApp/email, contenido SEO, datos estructurados y diseño responsive.

## Publicación

El repositorio está preparado para GitHub Pages mediante el workflow incluido. Para integrarlo en la web principal, publicar `index.html`, `styles.css` y `app.js` bajo:

`https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/`

Antes de producción, verificar que la URL canónica coincide con la definitiva. El formulario no almacena datos ni sube documentos: genera localmente un mensaje que el usuario decide enviar por WhatsApp o correo.

## Validación rápida

Abrir `index.html` en un servidor estático y recorrer las cuatro ramas del diagnóstico. El JavaScript no necesita compilación ni dependencias.
