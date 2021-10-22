<template>
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
</template>

<script>
export default {
    props: ["daily", "toKebabCase", "toDayOfWeek"],
}
</script>
