<template>
    <div class="current-weather flex items-center justify-between py-8 px-6">
        <div class="flex items-center">
            <div>
                <div class="font-semibold text-6xl">{{ actualTemp }}&deg;</div>
                <div class="text-sm">Feels Like {{ feelsLike }}&deg;</div>
            </div>
            <div class="mx-5">
                <div class="font-semibold">{{ summary }}</div>
                <div>{{ locationName }}</div>
            </div>
        </div>
        <div>
            <canvas id="iconCurrent" ref="iconCurrent" width="96" height="96"></canvas>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["actualTemp", "feelsLike", "summary", "locationName"]
    }
</script>
