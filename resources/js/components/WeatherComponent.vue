<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="text" class="w-full rounded">
        </div>
        <div class="weather-container font-sans w-128 max-w-lg overflow-hidden rounded-lg bg-gray-900 shadow-lg mt-4">
           <div class="current-weather flex items-center justify-between py-8 px-6">
               <div class="flex items-center">
                   <div>
                       <div class="font-semibold text-6xl">{{ currentTemperature.actual }}&deg;</div>
                       <div class="text-sm">Feels Like {{ currentTemperature.feels }}&deg;</div>
                   </div>
                    <div class="mx-5">
                        <div class="font-semibold">{{ currentTemperature.summary }}</div>
                        <div>{{ location.name }}</div>
                    </div>
               </div>
               <div>
                   <canvas id="iconCurrent" ref="iconCurrent" width="96" height="96"></canvas>
               </div>
           </div>
            <div class="future-weather text-xs bg-gray-700 px-6 py-8 overflow-hidden">
                <div v-for="(day, index) in daily" :key="index" class="flex items-center" :class="{'mt-8' : index > 0 }">
                    <div class="w-1/6 text-gray-200 text-lg">{{ toDayOfWeek(day.time) }}</div>
                    <div class="w-4/6 px-4 flex items-center">
                        <div><canvas :id="`icon${index+1}`" :data-icon="toKebabCase(day.icon)" width="24" height="24"></canvas></div>
                        <div class="ml-3">{{ day.summary }}</div>
                    </div>
                    <div class="w-1/4 text-right">
                        <div>{{ Math.round(day.temperatureHigh) }}&deg;</div>
                        <div>{{ Math.round(day.temperatureLow) }}&deg;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.fetchWeather();
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

