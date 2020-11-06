<template>
    <div class="inline-flex items-center">
        <p class="font-semibold uppercase tracking-widest">Time Left: {{ formattedTimeLeft }}</p>
    </div>
</template>

<script>


export default {
    props: ['duration'],  // in minute

    data() {
        return {
            timePassed: 0,
            timerInterval: null
        };
    },

    computed: {
        formattedTimeLeft() {
            const timeLeft = this.timeLeft; 
            let hours = Math.floor(timeLeft / 3600);
            let minutes = Math.floor(timeLeft / 60) >= 60 ? Math.floor(timeLeft / 60) - 60: Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            if (hours < 10) {
                hours = `0${hours}`;
            }
            if (minutes < 10) {
                minutes = `0${minutes}`;
            }
            if (seconds < 10) {
                seconds = `0${seconds}`;
            }

            return `${hours}:${minutes}:${seconds}`;
        },

        timeLeft() {
            return this.duration * 60 - this.timePassed; // duration converted to second
        }
    },

    methods: {
        onTimesUp() {
            this.$emit('times-up');
            clearInterval(this.timerInterval);
        },

        startTimer() {
            this.timerInterval = setInterval(() => (this.timePassed += 1), 1000);
        }
    },
    watch: {
        timeLeft(newValue) {
            if (newValue === 0) {
                this.onTimesUp();
            }
        }
    },

    mounted() {
        this.startTimer();
    },

    destroyed() {
        clearInterval(this.timerInterval);
    },
};
</script>

