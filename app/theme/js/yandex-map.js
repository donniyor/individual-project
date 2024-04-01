ymaps.ready(init);
var myMap;

function init () {
    ymaps.ready(init);
    function init() {
        var myPlacemark;
        let defaultCords = JSON.parse("[" + $('input[name*="[location]"]').val() + "]");

        myMap = new ymaps.Map('map', {
            center: defaultCords.length !== 0 ? defaultCords : [41.311151, 69.279737],
            zoom: 18
        }, {
            searchControlProvider: 'yandex#search'
        });

        if(defaultCords.length !== 0) {
            myPlacemark = createPlacemark(defaultCords);
            myMap.geoObjects.add(myPlacemark);
            myPlacemark.events.add('dragend', function () {
                getAddress(myPlacemark.geometry.getCoordinates());
            });
            getAddress(defaultCords);
        }

        myMap.events.add('click', function (e) {
            var coords = e.get('coords');
            $('input[name*="[location]"]').val(coords);
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
            }
            getAddress(coords);
        });

        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });
        }

        function getAddress(coords) {
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);

                myPlacemark.properties
                    .set({
                        iconCaption: [
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        balloonContent: firstGeoObject.getAddressLine()
                    });
            });
        }
    }
}