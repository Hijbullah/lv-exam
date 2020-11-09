<template>
    <DateTimePicker v-model="myDate" :options="options"></DateTimePicker>
</template>

<script>
  import DateTimePicker from "simple-vue2-datetimepicker";

  export default {
    components: {
      DateTimePicker
    },
    data() {
      return {
        myDate: new Date(),
        options: {
            // defaults
          timeFormat: {
            locale: "en-US",
            weekday: "short",
            year: "numeric",
            month: "short",
            day: "numeric",
            hour: "numeric",
            minute: "numeric",
            hour12: true
          },
          display: {
            maxWidth: 400
          }
        }
      };
    }
  };
</script>