# PRAETORIA — Embudo Hacienda y Seguridad Social

Landing estática de captación para personas que han recibido notificaciones de la AEAT, TGSS o INSS. Incluye diagnóstico guiado, resumen estructurado por WhatsApp/email, contenido SEO, datos estructurados y diseño responsive.

## Publicación

Desplegado en GitHub Pages mediante el workflow incluido:

`https://farinosv44.github.io/hacienda-/`

Esa es actualmente la URL real e indexable, por lo que `canonical`, `og:url` y el JSON-LD apuntan a ella. Si en el futuro este contenido se integra bajo `https://praetoriaabogados.es/abogado-hacienda-seguridad-social-valencia/`, hay que actualizar esas tres referencias a la URL definitiva (y considerar una redirección 301 desde la URL de GitHub Pages para no perder el posicionamiento acumulado). El formulario no almacena datos ni sube documentos: genera localmente un mensaje que el usuario decide enviar por WhatsApp o correo.

## Validación rápida

Abrir `index.html` en un servidor estático y recorrer las cuatro ramas del diagnóstico. El JavaScript no necesita compilación ni dependencias.
