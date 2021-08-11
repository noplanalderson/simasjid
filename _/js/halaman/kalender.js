function getKalenderAgenda(){
    $.ajax({
        type : 'GET',
        url : baseURI + '/data-kalender',
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                text: data,
                showConfirmButton: false,
                type: 'error'
            })
        },
        success : function(result) {
            if(result != null){             
                $('#calendar').html('');
                var listEvent = [];
                var response = result.response;
                for (var i = 0; i < response.length; i++) {
                    listEvent.push({
                        title: response[i].judul_kegiatan,
                        start: response[i].tanggal+"T"+response[i].jam_mulai,
                        end: response[i].tanggal+"T"+response[i].jam_selesai,
                        occur: "Jam " + response[i].jam_mulai+" - "+response[i].jam_selesai,
                        narasumber: "Narasumber: " + response[i].narasumber,
                        information: response[i].keterangan==null||response[i].keterangan==""?"":"Keterangan: "+response[i].keterangan
                        });
                }
                
                var Calendar = FullCalendar.Calendar;

                var containerEl = document.getElementById('external-events');
                var calendarEl = document.getElementById('calendar');
                
                var calendar = new Calendar(calendarEl, {
                    eventClick: function(info) {
                        var eventObj = info.event;
                        if (eventObj.url) {
                          alert(                            
                            'Buka ' + eventObj.url + ' di tab baru?'
                          );
                          window.open(eventObj.url);

                          info.jsEvent.preventDefault();
                        } else {
                            Swal.fire({
                              title: eventObj.title,
                              html: eventObj.extendedProps.occur + "<br>" + eventObj.extendedProps.narasumber + "<br>" +  eventObj.extendedProps.information
                            });
                        }
                      },
                  headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay',

                      close: 'fa-times',
                      prev: 'fa-chevron-left',
                      next: 'fa-chevron-right',
                      prevYear: 'fa-angle-double-left',
                      nextYear: 'fa-angle-double-right'
                  },
                  themeSystem: 'bootstrap',
                  locale: 'id',
                  events: listEvent
                });
                calendar.render();
            }
        }
    });
}

getKalenderAgenda();