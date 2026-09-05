(function(){
  'use strict';

  var TYPE_OPTIONS={
    'Hacienda / AEAT':['Requerimiento de información o documentación','Justificación de ingresos o movimientos bancarios','Comprobación limitada','Propuesta de liquidación','Liquidación provisional','Inicio de expediente sancionador','Sanción tributaria','Providencia de apremio','Diligencia de embargo','Derivación de responsabilidad','Aplazamiento o fraccionamiento','Otra notificación','No sé identificarla'],
    'Seguridad Social / TGSS':['Reclamación de deuda','Providencia de apremio','Diligencia de embargo','Diferencias de cotización','Acta de liquidación','Sanción','Cuotas de autónomos','Devolución de ingresos indebidos','Aplazamiento','Derivación de responsabilidad','Otra notificación','No sé identificarla'],
    'INSS':['Resolución sobre una prestación','Reintegro de prestaciones','Requerimiento de documentación','Otra resolución','No sé identificarla'],
    'No lo sé':['Requerimiento de información o documentación','Reclamación de deuda','Liquidación o sanción','Providencia de apremio o embargo','Otra notificación','No sé identificarla']
  };

  function track(eventName,details){
    var name='phf_'+eventName;
    if(typeof window.gtag==='function'){
      window.gtag('event',name,details||{});
      return;
    }
    window.dataLayer=window.dataLayer||[];
    window.dataLayer.push(Object.assign({event:name},details||{}));
  }

  function initFunnel(root){
    var form=root.querySelector('.phf-case-form');
    if(!form||form.dataset.phfInit)return;
    form.dataset.phfInit='true';

    var steps=[].slice.call(root.querySelectorAll('.phf-step'));
    var progress=root.querySelector('.phf-progress');
    var stepLabel=root.querySelector('.phf-step-label');
    var prevBtn=root.querySelector('.phf-prev');
    var nextBtn=root.querySelector('.phf-next');
    var submitBtn=root.querySelector('.phf-submit');
    var errorBox=root.querySelector('.phf-form-error');
    var typeSelect=form.elements.tipo;
    var whatsappNumber=root.dataset.phfWhatsapp||'34607527719';
    var contactEmail=root.dataset.phfEmail||'juanfarinos@icav.es';
    var current=0;

    function showStep(index,moveFocus){
      current=index;
      steps.forEach(function(step,i){step.classList.toggle('phf-active',i===index)});
      if(progress)progress.value=index+1;
      if(stepLabel)stepLabel.textContent='Paso '+(index+1)+' de '+steps.length;
      if(prevBtn)prevBtn.hidden=index===0;
      if(nextBtn)nextBtn.hidden=index===steps.length-1;
      if(submitBtn)submitBtn.hidden=index!==steps.length-1;
      if(errorBox)errorBox.textContent='';
      if(moveFocus){
        var legend=steps[index].querySelector('legend');
        if(legend&&legend.focus)legend.focus();
      }
    }

    function validateStep(){
      var controls=[].slice.call(steps[current].querySelectorAll('input,select,textarea'));
      for(var i=0;i<controls.length;i++){
        if(!controls[i].checkValidity()){
          controls[i].reportValidity();
          if(errorBox)errorBox.textContent='Revisa el campo indicado para poder continuar.';
          return false;
        }
      }
      return true;
    }

    function populateTypes(){
      var selected=form.elements.administracion.value;
      typeSelect.innerHTML='<option value="">Seleccionar…</option>';
      (TYPE_OPTIONS[selected]||TYPE_OPTIONS['No lo sé']).forEach(function(item){
        typeSelect.add(new Option(item,item));
      });
    }

    [].slice.call(form.elements.administracion).forEach(function(radio){
      radio.addEventListener('change',populateTypes);
    });

    if(nextBtn)nextBtn.addEventListener('click',function(){
      if(!validateStep())return;
      track('funnel_step_completed',{step:current+1});
      showStep(current+1,true);
    });
    if(prevBtn)prevBtn.addEventListener('click',function(){showStep(Math.max(0,current-1),true)});

    var textarea=form.querySelector('textarea[name="descripcion"]');
    var counter=root.querySelector('.phf-counter');
    if(textarea&&counter){
      textarea.addEventListener('input',function(e){counter.textContent=e.target.value.length+'/900'});
    }

    form.addEventListener('focusin',function once(){
      if(form.dataset.phfStarted)return;
      form.dataset.phfStarted='true';
      track('funnel_started',{});
      form.removeEventListener('focusin',once);
    });

    form.addEventListener('submit',function(event){
      event.preventDefault();
      if(!validateStep())return;
      var data=new FormData(form);
      var received=data.get('fecha_recepcion')||'No indicada';
      var deadline=data.get('fecha_limite')||'No indicada';
      var message=[
        'Hola, he completado la orientación inicial de PRAETORIA y quiero que reviséis mi notificación.',
        '',
        'Nombre: '+data.get('nombre'),
        'Teléfono: '+data.get('telefono'),
        'Email: '+(data.get('email')||'No indicado'),
        'Administración: '+data.get('administracion'),
        'Tipo de notificación: '+data.get('tipo'),
        'Fecha de recepción/apertura: '+received,
        'Fecha límite indicada: '+deadline,
        'Importe aproximado: '+data.get('importe'),
        '',
        'Resumen: '+data.get('descripcion'),
        '',
        'Sé que el plazo debe verificarse en la notificación completa.'
      ].join('\n');

      var waLink=root.querySelector('.phf-whatsapp-link');
      var emailLink=root.querySelector('.phf-email-link');
      if(waLink)waLink.href='https://api.whatsapp.com/send?phone='+whatsappNumber+'&text='+encodeURIComponent(message);
      if(emailLink)emailLink.href='mailto:'+contactEmail+'?subject='+encodeURIComponent('Revisión de notificación administrativa')+'&body='+encodeURIComponent(message);

      form.hidden=true;
      var intro=root.querySelector('.phf-assessment-intro');
      if(intro)intro.hidden=true;
      var success=root.querySelector('.phf-success');
      if(success){
        success.hidden=false;
        if(success.focus)success.focus();
      }
      track('lead_summary_prepared',{});
    });

    var waLinkEl=root.querySelector('.phf-whatsapp-link');
    if(waLinkEl)waLinkEl.addEventListener('click',function(){track('lead_whatsapp_opened',{})});
    var emailLinkEl=root.querySelector('.phf-email-link');
    if(emailLinkEl)emailLinkEl.addEventListener('click',function(){track('lead_email_opened',{})});
    var restartBtn=root.querySelector('.phf-restart');
    if(restartBtn)restartBtn.addEventListener('click',function(){
      var success=root.querySelector('.phf-success');
      if(success)success.hidden=true;
      form.hidden=false;
      var intro=root.querySelector('.phf-assessment-intro');
      if(intro)intro.hidden=false;
      showStep(4,true);
    });
    [].slice.call(root.querySelectorAll('[data-phf-track="phone"]')).forEach(function(link){
      link.addEventListener('click',function(){track('phone_clicked',{})});
    });

    var fechaRecepcion=form.elements.fecha_recepcion;
    if(fechaRecepcion)fechaRecepcion.max=new Date().toISOString().slice(0,10);

    showStep(0);
    track('landing_view',{});
  }

  function init(){
    [].slice.call(document.querySelectorAll('.phf-funnel')).forEach(initFunnel);
  }

  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded',init);
  }else{
    init();
  }
})();
