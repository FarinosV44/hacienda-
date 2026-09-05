<?php
/**
 * Plugin Name: PRAETORIA - Hacienda y Seguridad Social Funnel
 * Plugin URI: https://github.com/FarinosV44/hacienda-
 * Description: Diagnostic funnel for Hacienda/AEAT, TGSS, INSS and Seguridad Social administrative notices, styled to match the PRAETORIA Abogados identity. Insert with the [praetoria_hacienda_funnel] shortcode.
 * Version: 1.0.0
 * Author: PRAETORIA Division Juridica
 * Text Domain: praetoria-hacienda-funnel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PHF_VERSION', '1.0.0' );
define( 'PHF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PHF_WHATSAPP_NUMBER', '34607527719' );
define( 'PHF_CONTACT_EMAIL', 'juanfarinos@icav.es' );
define( 'PHF_PHONE_DISPLAY', '607 527 719' );
define( 'PHF_AMBITOS_URL', 'https://praetoriaabogados.es/ambitos-de-especializacion/' );

add_action( 'wp_enqueue_scripts', 'phf_maybe_enqueue_assets' );
/**
 * Only loads the funnel's CSS/JS on pages that actually use the shortcode,
 * so the rest of the WordPress site is never affected.
 */
function phf_maybe_enqueue_assets() {
	if ( ! is_singular() ) {
		return;
	}
	$post = get_post();
	if ( ! $post || ! has_shortcode( $post->post_content, 'praetoria_hacienda_funnel' ) ) {
		return;
	}
	wp_enqueue_style( 'phf-google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&family=Roboto+Slab:wght@400;600&display=swap', array(), null );
	wp_enqueue_style( 'phf-funnel', PHF_PLUGIN_URL . 'assets/funnel.css', array(), PHF_VERSION );
	wp_enqueue_script( 'phf-funnel', PHF_PLUGIN_URL . 'assets/funnel.js', array(), PHF_VERSION, true );
}

add_shortcode( 'praetoria_hacienda_funnel', 'phf_render_shortcode' );

/**
 * Renders the full landing content: hero, 5-step diagnostic form, services
 * recap, method, FAQ (with FAQPage schema) and final CTA. Everything is
 * scoped under .phf-funnel so it cannot collide with the Astra/Elementor
 * theme or other plugins.
 */
function phf_render_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'whatsapp'      => PHF_WHATSAPP_NUMBER,
			'email'         => PHF_CONTACT_EMAIL,
			'phone_display' => PHF_PHONE_DISPLAY,
		),
		$atts,
		'praetoria_hacienda_funnel'
	);

	$whatsapp_number = preg_replace( '/[^0-9]/', '', $atts['whatsapp'] );
	$contact_email   = sanitize_email( $atts['email'] );
	$phone_display   = esc_html( $atts['phone_display'] );
	$tel_href        = 'tel:+' . $whatsapp_number;
	$page_url        = get_permalink();

	$faqs = array(
		array(
			'q' => 'Me ha llegado una carta de Hacienda, ¿qué debo hacer?',
			'a' => 'No la ignores ni envíes documentación sin revisar antes qué procedimiento se ha iniciado. Conserva la notificación completa y anota cuándo la recibiste o abriste para comprobar el plazo aplicable.',
		),
		array(
			'q' => '¿Cuánto tiempo tengo para contestar un requerimiento de Hacienda?',
			'a' => 'Depende del acto recibido y de la forma y fecha de notificación. El plazo debe verificarse en el documento completo; no conviene esperar al último día.',
		),
		array(
			'q' => '¿Se puede recurrir una liquidación o una sanción de Hacienda?',
			'a' => 'En muchos casos existen vías de alegación o recurso, pero deben valorarse el expediente, los hechos, las pruebas, la motivación y el plazo concreto.',
		),
		array(
			'q' => '¿Recurrir paraliza automáticamente el cobro?',
			'a' => 'No siempre. La impugnación y el riesgo recaudatorio deben estudiarse conjuntamente según el acto y la fase del procedimiento.',
		),
		array(
			'q' => '¿Qué puedo hacer si me embargan una cuenta por una deuda de Hacienda o de la Seguridad Social?',
			'a' => 'Conviene revisar de inmediato el origen de la deuda, si el procedimiento se notificó correctamente y si existen motivos de oposición al apremio o al propio embargo, antes de que se ejecuten más actuaciones.',
		),
		array(
			'q' => '¿Puede Hacienda derivar la responsabilidad de una deuda al administrador de la empresa?',
			'a' => 'En determinados supuestos sí, mediante un expediente de derivación de responsabilidad. Es un procedimiento independiente que también admite alegaciones y recurso, y conviene analizarlo cuanto antes.',
		),
		array(
			'q' => '¿Qué documentación necesitáis para estudiar mi caso?',
			'a' => 'La notificación completa, la fecha de recepción o apertura, los documentos relacionados y una explicación breve de lo sucedido.',
		),
		array(
			'q' => '¿Podéis atenderme fuera de Valencia o de El Puig?',
			'a' => 'Sí. Muchos procedimientos con Hacienda y la Seguridad Social se tramitan electrónicamente, por lo que podemos estudiar documentación y preparar actuaciones en toda España.',
		),
	);

	$faq_schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array_map(
			function ( $faq ) {
				return array(
					'@type'          => 'Question',
					'name'           => $faq['q'],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => $faq['a'],
					),
				);
			},
			$faqs
		),
	);

	$breadcrumb_schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => array(
			array(
				'@type'    => 'ListItem',
				'position' => 1,
				'name'     => 'Inicio',
				'item'     => home_url( '/' ),
			),
			array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => 'Ámbitos de Especialización',
				'item'     => PHF_AMBITOS_URL,
			),
			array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => 'Hacienda y Seguridad Social',
				'item'     => $page_url ? $page_url : PHF_AMBITOS_URL,
			),
		),
	);

	ob_start();
	?>
	<div class="phf-funnel" data-phf-whatsapp="<?php echo esc_attr( $whatsapp_number ); ?>" data-phf-email="<?php echo esc_attr( $contact_email ); ?>">

		<script type="application/ld+json"><?php echo wp_json_encode( $breadcrumb_schema ); ?></script>
		<script type="application/ld+json"><?php echo wp_json_encode( $faq_schema ); ?></script>

		<section class="phf-hero phf-section">
			<div class="phf-hero-copy">
				<p class="phf-eyebrow">Defensa administrativa · Valencia, El Puig y toda España</p>
				<h1>Abogados para requerimientos de <em>Hacienda y Seguridad Social</em></h1>
				<p class="phf-lead">¿Has recibido una carta, liquidación, sanción o reclamación de deuda de Hacienda o de la Seguridad Social? Estudiamos la notificación, comprobamos los plazos y planteamos la respuesta, alegación o recurso adecuado.</p>
				<div class="phf-trust-row" aria-label="Ventajas del servicio">
					<span>Abogados</span><span>Economistas</span><span>Especialistas fiscales</span>
				</div>
				<a class="phf-text-link" href="#phf-diagnostico">Revisar qué he recibido <span aria-hidden="true">↓</span></a>
			</div>
			<aside class="phf-deadline-card">
				<span class="phf-card-number">01</span>
				<p class="phf-eyebrow phf-light">Lo primero</p>
				<h2>No dejes correr el plazo</h2>
				<p>Una respuesta bien planteada desde el inicio puede evitar que el problema avance hacia recargos, sanciones o apremio.</p>
				<div class="phf-deadline-line"><span></span><small>El plazo exacto debe comprobarse en tu notificación.</small></div>
			</aside>
		</section>

		<section class="phf-section phf-soft phf-assessment" id="phf-diagnostico" aria-labelledby="phf-diagnostico-title">
			<div class="phf-assessment-intro">
				<p class="phf-eyebrow">Orientación inicial</p>
				<h2 id="phf-diagnostico-title">¿Qué notificación has recibido?</h2>
				<p>Responde unas preguntas breves. Prepararemos un resumen para que puedas enviárnoslo directamente por WhatsApp, sin subir documentación sensible a esta página.</p>
				<p class="phf-privacy-note">Tus respuestas permanecen en tu dispositivo hasta que decidas enviarlas.</p>
			</div>

			<form class="phf-case-form" novalidate>
				<div class="phf-progress-wrap"><span class="phf-step-label" aria-live="polite">Paso 1 de 5</span><progress class="phf-progress" value="1" max="5" aria-hidden="true">20%</progress></div>

				<fieldset class="phf-step phf-active" data-step="1">
					<legend tabindex="-1">¿Quién te ha enviado la notificación?</legend>
					<div class="phf-option-grid">
						<label class="phf-option"><input type="radio" name="administracion" value="Hacienda / AEAT" required><span><b>Hacienda</b><small>Agencia Tributaria · AEAT</small></span></label>
						<label class="phf-option"><input type="radio" name="administracion" value="Seguridad Social / TGSS"><span><b>Seguridad Social</b><small>Tesorería General · TGSS</small></span></label>
						<label class="phf-option"><input type="radio" name="administracion" value="INSS"><span><b>INSS</b><small>Prestaciones y resoluciones</small></span></label>
						<label class="phf-option"><input type="radio" name="administracion" value="No lo sé"><span><b>No lo sé</b><small>Te ayudamos a identificarla</small></span></label>
					</div>
				</fieldset>

				<fieldset class="phf-step" data-step="2">
					<legend tabindex="-1">¿Qué tipo de documento parece ser?</legend>
					<label class="phf-field"><span>Selecciona la opción más parecida</span><select name="tipo" required><option value="">Seleccionar…</option></select></label>
					<p class="phf-field-help">No pasa nada si no sabes identificarlo. Para confirmarlo necesitaremos revisar el documento completo.</p>
				</fieldset>

				<fieldset class="phf-step" data-step="3">
					<legend tabindex="-1">¿Cuándo lo recibiste?</legend>
					<div class="phf-two-cols">
						<label class="phf-field"><span>Fecha de recepción o apertura</span><input type="date" name="fecha_recepcion" required></label>
						<label class="phf-field"><span>Fecha límite indicada <i>(si la conoces)</i></span><input type="date" name="fecha_limite"></label>
					</div>
					<div class="phf-warning"><b>No esperes al último día.</b> Algunos plazos son breves y dejarlos transcurrir puede limitar las posibilidades de defensa.</div>
				</fieldset>

				<fieldset class="phf-step" data-step="4">
					<legend tabindex="-1">Cuéntanos brevemente qué ocurre</legend>
					<label class="phf-field"><span>Importe aproximado <i>(opcional)</i></span><select name="importe"><option>No aparece ninguna cantidad</option><option>Menos de 3.000 €</option><option>Entre 3.000 € y 10.000 €</option><option>Entre 10.000 € y 50.000 €</option><option>Más de 50.000 €</option><option>No lo sé</option></select></label>
					<label class="phf-field"><span>Descripción breve</span><textarea name="descripcion" rows="4" maxlength="900" required placeholder="Por ejemplo: Hacienda me solicita justificar varios ingresos recibidos en mi cuenta…"></textarea><small class="phf-counter">0/900</small></label>
				</fieldset>

				<fieldset class="phf-step" data-step="5">
					<legend tabindex="-1">¿Cómo podemos contactar contigo?</legend>
					<div class="phf-two-cols">
						<label class="phf-field"><span>Nombre</span><input type="text" name="nombre" autocomplete="name" required></label>
						<label class="phf-field"><span>Teléfono</span><input type="tel" name="telefono" autocomplete="tel" inputmode="tel" required></label>
					</div>
					<label class="phf-field"><span>Correo electrónico <i>(opcional)</i></span><input type="email" name="email" autocomplete="email"></label>
					<label class="phf-consent"><input type="checkbox" name="consentimiento" required><span>He leído y acepto la <a href="https://praetoriaabogados.es/politica-de-privacidad/" target="_blank" rel="noopener">Política de Privacidad</a>.</span></label>
					<p class="phf-legal-small">Enviar esta información no crea una relación abogado-cliente ni suspende o interrumpe ningún plazo administrativo.</p>
				</fieldset>

				<div class="phf-form-error" role="alert" aria-live="polite"></div>
				<div class="phf-form-actions">
					<button class="phf-btn phf-btn-ghost phf-prev" type="button" hidden>Anterior</button>
					<button class="phf-btn phf-next" type="button">Continuar</button>
					<button class="phf-btn phf-submit" type="submit" hidden>Enviar mi caso por WhatsApp</button>
				</div>
			</form>

			<div class="phf-success" hidden tabindex="-1">
				<p class="phf-eyebrow">Resumen preparado</p>
				<h3>Tu asunto necesita una revisión individual</h3>
				<p>Debemos comprobar el documento completo, la fecha de notificación, el procedimiento iniciado y la documentación relacionada.</p>
				<div class="phf-actions">
					<a class="phf-btn phf-btn-whatsapp phf-whatsapp-link" href="#" target="_blank" rel="noopener">Abrir WhatsApp y enviar</a>
					<a class="phf-text-link phf-email-link" href="#">Prefiero enviarlo por correo</a>
				</div>
				<button class="phf-plain-button phf-restart" type="button">Corregir mis respuestas</button>
			</div>
		</section>

		<section class="phf-section" id="phf-servicios">
			<div class="phf-section-heading">
				<div><p class="phf-eyebrow">Ámbitos de actuación</p><h2>Intervenimos antes de que el problema avance</h2></div>
				<p>Asistencia a particulares, autónomos, administradores y empresas en procedimientos administrativos y recaudatorios.</p>
			</div>
			<div class="phf-grid-2" style="margin-top:2.5rem">
				<article>
					<span class="phf-eyebrow">AEAT · 01</span>
					<h3>Hacienda: requerimientos, liquidaciones y sanciones</h3>
					<p>Requerimientos de información, justificación de ingresos y movimientos bancarios, comprobaciones de IRPF, IVA o Sociedades, propuestas de liquidación y expedientes sancionadores.</p>
					<ul class="phf-check">
						<li>Cómo contestar un requerimiento de Hacienda</li>
						<li>Hacienda me pide justificar ingresos: qué hacer</li>
						<li>Recurrir una sanción de Hacienda</li>
						<li>Recurso contra una propuesta de liquidación</li>
						<li>Derivación de responsabilidad tributaria al administrador</li>
						<li>Aplazamientos y fraccionamientos de deuda</li>
					</ul>
				</article>
				<article>
					<span class="phf-eyebrow">TGSS / INSS · 02</span>
					<h3>Seguridad Social: deudas, apremios y embargos</h3>
					<p>Reclamaciones de deuda, diferencias de cotización, actas de liquidación, sanciones, cuotas de autónomos y resoluciones de prestaciones del INSS.</p>
					<ul class="phf-check">
						<li>Reclamación de deuda de la Seguridad Social</li>
						<li>Providencia de apremio de la TGSS</li>
						<li>Embargo de Hacienda o Seguridad Social</li>
						<li>Diferencias de cotización y actas de liquidación</li>
						<li>Devolución de ingresos indebidos</li>
					</ul>
				</article>
			</div>
		</section>

		<section class="phf-section phf-soft">
			<h2>Abogado fiscal en Valencia y El Puig, también para autónomos</h2>
			<p style="max-width:760px">Actuamos como abogados fiscales para particulares, autónomos y empresas de Valencia, El Puig de Santa María y el resto de España. Muchos procedimientos con Hacienda y la Seguridad Social se tramitan electrónicamente, por lo que en la mayoría de los casos podemos revisar la documentación y plantear la defensa sin necesidad de desplazamiento.</p>
		</section>

		<section class="phf-section" id="phf-metodo">
			<p class="phf-eyebrow">Método PRAETORIA</p>
			<h2>Claridad para decidir. Rigor para defender.</h2>
			<p style="max-width:760px">Un equipo multidisciplinar de abogados, economistas y especialistas fiscales analiza conjuntamente las implicaciones jurídicas y económicas de tu caso.</p>
			<ol class="phf-method-steps">
				<li><span>01</span><div><h3>Identificamos</h3><p>El acto recibido, el procedimiento y la fecha que condiciona la actuación.</p></div></li>
				<li><span>02</span><div><h3>Estudiamos</h3><p>El expediente, la documentación, los cálculos y los riesgos existentes.</p></div></li>
				<li><span>03</span><div><h3>Planteamos</h3><p>La respuesta, alegación, recurso o solución de pago adecuada al caso.</p></div></li>
				<li><span>04</span><div><h3>Explicamos</h3><p>El trabajo necesario y los honorarios antes de iniciar la actuación.</p></div></li>
			</ol>
			<a class="phf-btn" href="#phf-diagnostico" style="margin-top:1.5rem">Revisar mi notificación</a>
		</section>

		<section class="phf-section phf-soft" id="phf-preguntas">
			<p class="phf-eyebrow">Preguntas frecuentes</p>
			<h2>Lo urgente es saber dónde estás</h2>
			<p style="max-width:760px">Cada notificación exige una lectura individual. Estas respuestas ofrecen una orientación general y no sustituyen la revisión de tu caso.</p>
			<div class="phf-accordion" style="margin-top:2rem">
				<?php foreach ( $faqs as $faq ) : ?>
				<details class="phf-faq">
					<summary><?php echo esc_html( $faq['q'] ); ?></summary>
					<p><?php echo esc_html( $faq['a'] ); ?></p>
				</details>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="phf-section phf-final-cta">
			<p class="phf-eyebrow phf-light">PRAETORIA · El Puig, Valencia</p>
			<h2>Cuanto antes estudiemos la notificación, más opciones tendremos para plantear una buena defensa.</h2>
			<div style="display:flex;flex-wrap:wrap;gap:1rem;justify-content:center">
				<a class="phf-btn" href="#phf-diagnostico">Quiero que reviséis mi caso</a>
				<a class="phf-btn phf-btn-ghost" href="<?php echo esc_url( $tel_href ); ?>" data-phf-track="phone">Llamar al <?php echo $phone_display; ?></a>
			</div>
		</section>

	</div>
	<?php
	return ob_get_clean();
}
