const form=document.querySelector('#case-form');
const steps=[...document.querySelectorAll('.step')];
const progress=document.querySelector('#progress');
const stepLabel=document.querySelector('#step-label');
const previous=document.querySelector('#prev');
const next=document.querySelector('#next');
const submit=document.querySelector('#submit');
const errorBox=document.querySelector('#form-error');
const typeSelect=form.elements.tipo;
let current=0;

const options={
  'Hacienda / AEAT':['Requerimiento de información o documentación','Justificación de ingresos o movimientos bancarios','Comprobación limitada','Propuesta de liquidación','Liquidación provisional','Inicio de expediente sancionador','Sanción tributaria','Providencia de apremio','Diligencia de embargo','Derivación de responsabilidad','Aplazamiento o fraccionamiento','Otra notificación','No sé identificarla'],
  'Seguridad Social / TGSS':['Reclamación de deuda','Providencia de apremio','Diligencia de embargo','Diferencias de cotización','Acta de liquidación','Sanción','Cuotas de autónomos','Devolución de ingresos indebidos','Aplazamiento','Derivación de responsabilidad','Otra notificación','No sé identificarla'],
  'INSS':['Resolución sobre una prestación','Reintegro de prestaciones','Requerimiento de documentación','Otra resolución','No sé identificarla'],
  'No lo sé':['Requerimiento de información o documentación','Reclamación de deuda','Liquidación o sanción','Providencia de apremio o embargo','Otra notificación','No sé identificarla']
};

function track(eventName,details={}){window.dataLayer=window.dataLayer||[];window.dataLayer.push({event:eventName,...details});}
function showStep(index,moveFocus){current=index;steps.forEach((step,i)=>step.classList.toggle('active',i===index));progress.value=index+1;stepLabel.textContent=`Paso ${index+1} de ${steps.length}`;previous.hidden=index===0;next.hidden=index===steps.length-1;submit.hidden=index!==steps.length-1;errorBox.textContent='';if(moveFocus)steps[index].querySelector('legend')?.focus?.();}
function validateStep(){const controls=[...steps[current].querySelectorAll('input,select,textarea')];for(const control of controls){if(!control.checkValidity()){control.reportValidity();errorBox.textContent='Revisa el campo indicado para poder continuar.';return false}}return true}
function populateTypes(){const selected=form.elements.administracion.value;typeSelect.innerHTML='<option value="">Seleccionar…</option>';(options[selected]||options['No lo sé']).forEach(item=>typeSelect.add(new Option(item,item)));}

form.elements.administracion.forEach(radio=>radio.addEventListener('change',populateTypes));
next.addEventListener('click',()=>{if(!validateStep())return;track('funnel_step_completed',{step:current+1});showStep(current+1,true)});
previous.addEventListener('click',()=>showStep(Math.max(0,current-1),true));
form.querySelector('textarea').addEventListener('input',event=>document.querySelector('.counter').textContent=`${event.target.value.length}/900`);
form.addEventListener('focusin',()=>{if(!form.dataset.started){form.dataset.started='true';track('funnel_started')}},{once:true});

form.addEventListener('submit',event=>{
  event.preventDefault();if(!validateStep())return;
  const data=new FormData(form);const received=data.get('fecha_recepcion')||'No indicada';const deadline=data.get('fecha_limite')||'No indicada';
  const message=[
    'Hola, he completado la orientación inicial de PRAETORIA y quiero que reviséis mi notificación.',
    '',`Nombre: ${data.get('nombre')}`,`Teléfono: ${data.get('telefono')}`,`Email: ${data.get('email')||'No indicado'}`,
    `Administración: ${data.get('administracion')}`,`Tipo de notificación: ${data.get('tipo')}`,`Fecha de recepción/apertura: ${received}`,`Fecha límite indicada: ${deadline}`,`Importe aproximado: ${data.get('importe')}`,
    '',`Resumen: ${data.get('descripcion')}`,'','Sé que el plazo debe verificarse en la notificación completa.'
  ].join('\n');
  document.querySelector('#whatsapp-link').href=`https://api.whatsapp.com/send?phone=34607527719&text=${encodeURIComponent(message)}`;
  document.querySelector('#email-link').href=`mailto:juanfarinos@icav.es?subject=${encodeURIComponent('Revisión de notificación administrativa')}&body=${encodeURIComponent(message)}`;
  form.hidden=true;document.querySelector('.assessment-intro').hidden=true;const success=document.querySelector('#success');success.hidden=false;success.focus();track('lead_summary_prepared');
});
document.querySelector('#whatsapp-link').addEventListener('click',()=>track('lead_whatsapp_opened'));
document.querySelector('#email-link').addEventListener('click',()=>track('lead_email_opened'));
document.querySelector('#restart').addEventListener('click',()=>{document.querySelector('#success').hidden=true;form.hidden=false;document.querySelector('.assessment-intro').hidden=false;showStep(4,true)});
document.querySelectorAll('[data-track="phone"]').forEach(link=>link.addEventListener('click',()=>track('phone_clicked')));
form.elements.fecha_recepcion.max=new Date().toISOString().slice(0,10);
showStep(0);
