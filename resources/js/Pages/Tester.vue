<template>
    <div class="text-white">
        <div v-for="item in table_contact">
            {{  item.table_id }}
        </div>
    </div>
</template>
<script>
export default {
    props: {
        table_contact: Array,
    },
}
</script>