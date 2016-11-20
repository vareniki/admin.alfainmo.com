<?php
// app/View/Inmuebles/view.ctp
$this->extend('/Common/view2top');
$this->start('sidebar');

$title = 'Agenda';
$this->set('title_for_layout', $title);

$this->end();

$this->start('header');
$this->Html->css(array('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.8.0/fullcalendar.css'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui.min',
	'//cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js',
	'//cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/locale/es.js',
	'//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.8.0/fullcalendar.min.js'));
?>
<script type="text/javascript">

	var agenteId = <?php echo ($profile['is_agente']) ? $agente['Agente']['id'] : 'null';  ?>;
	var userId = <?php echo $user['id']; ?>;

	function displayMessage(message) {
		$('#message').html(message).fadeIn();
	}

	$(document).ready(function () {

		var options = {
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay',
			},
			editable: true,
			timeFormat: 'H(:mm)',
			monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
			monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			dayNames: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
			buttonText: {
				today: 'hoy',
				month: 'mes',
				week: 'semana',
				day: 'día'
			},
			firstDay: 1,

			events: function (start, end, timezone, callback) {

				$.ajax({
					url: '<?php echo $this->base; ?>/ajax/getEventosAgenda',
					dataType: 'json',
					data: {
						start: start.unix(),
						end: end.unix()
					},
					success: function(doc) {
						var events = [];
						$(doc).each(function() {

							var color=0;
							switch (this.Evento.estado) {
								case 0:
									color = '#9C0002';
									break;
								case 1:
									color = '#358B02';
									break;
								case 2:
									color = '#AAA';
									break;
							}
							var textColor;
							if (agenteId == null || agenteId == this.Evento.agente_id || userId == this.Evento.user_id) {
								textColor = 'white';
							} else {
								textColor = '#F0F0CC';
							}

							var className = 'envcal ' + ((this.Evento.agente_id == null) ? 'evncal-oficina' : 'evncal-' + this.Evento.agente_id);

							events.push({
								title: this.TipoEvento.description,
								start: this.Evento.fecha,
								allDay: false,
								color: color,
								textColor: textColor,
								more: this,
								className: className
							});
						});
						callback(events);

						// Muestra u oculta elementos
						var valAgente = $("#agente").val();

						if (valAgente == '') {
							$("a[class*='evncal']").show();
						} else {
							$("a[class*='evncal']").hide();
							$("a[class*='evncal-" + valAgente + "']").show();
						}
					}
				});

			},

			eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {

				$.ajax({
					url: '<?php echo $this->base; ?>/ajax/changeEventDate',
					dataType: 'json',
					data: {
						eventId: event.more.Evento.id,
						dateTime: event.start.format("YYYY-MM-DD HH:mm")
					},
					success: function(doc) {

					}
				});

			},

			eventMouseover: function(event, jsEvent, view ) {

				var tooltip = '<strong>' + event.title + '</strong>';
				if (event.more.Demandante.nombre_contacto != null) {
					tooltip += '<br>' +
						'&nbsp;Demandante: ' +
							event.more.Demandante.nombre_contacto + ' / ' +
							event.more.Demandante.telefono1_contacto + ' ' +
							'<a href="mailto:' + event.more.Demandante.email_contacto + '">' + event.more.Demandante.email_contacto + '</a>';
				}

				if (event.more.Propietario.nombre_contacto != null) {
					tooltip += '<br>' +
						'&nbsp;Propietario: ' +
						event.more.Propietario.nombre_contacto + ' / ' +
						event.more.Propietario.telefono1_contacto + ' ' +
						'<a href="mailto:' + event.more.Propietario.email_contacto + '">' + event.more.Propietario.email_contacto + '</a>';
				}

				if (event.more.Inmueble.numero_agencia != null) {
					tooltip += '<br>' +
						'&nbsp;Inmueble: ' +
						event.more.Inmueble.numero_agencia + '/' + event.more.Inmueble.codigo;
				}

				if (event.more.Agente.nombre_contacto != null) {
					tooltip += '<br>' +
					'&nbsp;Agente: ' +
					event.more.Agente.nombre_contacto;
				}

				var tooltip = '<div class="tooltipevent">' + tooltip + '</div>';
				$("body").append(tooltip);
				$(this).mouseover(function(e) {
					$(this).css('z-index', 10000);
				}).mousemove(function(e) {
					$('.tooltipevent').css('top', e.pageY + 10);
					$('.tooltipevent').css('left', e.pageX + 20);
				});

			},

			eventMouseout: function(calEvent, jsEvent) {
				$(this).css('z-index', 8);
				$('.tooltipevent').remove();
			},

			eventClick: function(event, jsEvent, view) {
				if (agenteId == null || agenteId == event.more.Evento.agente_id || userId == event.more.Evento.user_id) {
					window.location.href = '<?php echo $this->Html->url("/agenda/edit/"); ?>' + event.more.Evento.id;
				} else {
					alert('No dispone de permisos para modificar una acción de ' + event.more.Agente.nombre_contacto);
				}

			}

		};

		$('#calendar').fullCalendar(options);

		$('#agente').on("change", function() {
			if (this.value == '') {
				$("a[class*='evncal']").show();
			} else {
				$("a[class*='evncal']").hide();
				$("a[class*='evncal-" + this.value + "']").show();
			}
		});

	});
</script>
<?php
$this->end();

$this->start('sidebar');
echo $this->element('agenda_top');
$this->end();
echo $this->Form->select('agente', $agentes, array('name' => 'agente', 'class' => 'form-control')); ?>
<br>
<div id="calendar" class="cal-context"></div>
