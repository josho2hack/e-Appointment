<template>
    <div class="card" ref="cal"></div>
</template>

<script>
import { ref, defineComponent, onMounted } from "vue";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import thLocale from "@fullcalendar/core/locales/th";

export default {
    setup() {
        const cal = ref(null);

        onMounted(() => {
            const Tcalendar = new Calendar(cal.value, {
                locale: thLocale,
                firstDay: 0,
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
                initialView: "dayGridMonth",
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,listWeek",
                },
                events: [
                    { title: "event 1", date: "2021-03-01" },
                    { title: "event 2", date: "2021-03-02" },
                ],
            });
            Tcalendar.render();
        });
        return {
            cal,
        };
    },
};
</script>

<style></style>
