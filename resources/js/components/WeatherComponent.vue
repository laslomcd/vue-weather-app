<template>

    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="search" id="address" class="w-full rounded" placeholder="Enter a city">
            <p class="ml-3">Selected: <strong id="address-value">none</strong></p>
        </div>
        <div class="weather-container font-sans w-128 max-w-lg overflow-hidden rounded-lg bg-gray-900 shadow-lg mt-4">
            <current-weather
                :actualTemp="currentTemperature.actual"
                :feelsLike="currentTemperature.feels"
                :summary="currentTemperature.summary"
                :locationName="location.name"
            ></current-weather>
            <future-weather
                :daily="daily"
                :toKebabCase="toKebabCase"
                :toDayOfWeek="toDayOfWeek"
            ></future-weather>

        </div>
    </div>
</template>

<script>
    import CurrentComponent from "./CurrentComponent";
    import FutureComponent from "./FutureComponent";

    export default {
        components: {
            "current-weather": CurrentComponent,
            "future-weather": FutureComponent
        },
        mounted() {
            var placesAutocomplete = places({
                appId: 'plVXKLV5GWPG',
                apiKey: '62ac411694a472c6589c95bd0d8b4869',
                container: document.querySelector('#address')
            }).configure({
                type: 'city',
                aroundLatLngViaIP: false,
            });
            var $address = document.querySelector('#address-value')
            placesAutocomplete.on('change', (e) => {
                $address.textContent = e.suggestion.value

                this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`
                this.location.lat = e.suggestion.latlng.lat
                this.location.lng = e.suggestion.latlng.lng

            });
            placesAutocomplete.on('clear', function() {
                $address.textContent = 'none';
            });
            this.fetchWeather();
        },
        watch: {
          location: {
              handler(newValue, oldValue) {
                  this.fetchWeather()
              },
              deep: true
          }
        },
        data() {
          return {
              currentTemperature: {
                actual: '',
                feels: '',
                summary: '',
                icon: ''
              },
              location: {
                  name: 'Toledo, Ohio',
                  lat: 41.7,
                  lng: -83.5
              },
              daily: [],
          }
        },
        methods: {
            fetchWeather() {
                let skycons = new Skycons({'color': 'white'});


                 axios.get(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)
                // .then(response => console.log(response.data))
                .then(response => {
                    this.currentTemperature.actual = Math.round(response.data.currently.temperature);
                    this.currentTemperature.feels = Math.round(response.data.currently.apparentTemperature)
                    this.currentTemperature.summary = response.data.currently.summary
                    this.currentTemperature.icon = this.toKebabCase(response.data.currently.icon)
                    this.daily = response.data.daily.data

                    skycons.add('iconCurrent', this.currentTemperature.icon)
                    skycons.play()

                    this.$nextTick(() => {
                        skycons.add('icon1', document.getElementById('icon1').getAttribute('data-icon'))
                        skycons.add('icon2', document.getElementById('icon2').getAttribute('data-icon'))
                        skycons.add('icon3', document.getElementById('icon3').getAttribute('data-icon'))
                        skycons.add('icon4', document.getElementById('icon4').getAttribute('data-icon'))
                        skycons.add('icon5', document.getElementById('icon5').getAttribute('data-icon'))
                        skycons.add('icon6', document.getElementById('icon6').getAttribute('data-icon'))
                        skycons.add('icon7', document.getElementById('icon7').getAttribute('data-icon'))
                        skycons.add('icon8', document.getElementById('icon8').getAttribute('data-icon'))
                        skycons.play()
                    })

                })
            },
            toKebabCase(stringToConvert) {
                return stringToConvert.split(' ').join('-')
            },
            toDayOfWeek(timestamp) {
                const newDate = new Date(timestamp*1000)
                const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                return days[newDate.getDay()]
            }
        }
    }
</script>

