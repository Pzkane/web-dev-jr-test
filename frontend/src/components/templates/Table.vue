<template>
  <div>
    <table>
      <tr>
        <th>ID</th>
        <th>E-mail</th>
        <th>Subscribed At</th>
      </tr>
      <tr v-for="record in emailRecords" :key="record.id">
        <th>{{ record.id }}</th>
        <th>{{ record.email }}</th>
        <th>{{ record.created_at }}</th>
      </tr>
    </table>
  </div>
</template>

<script lang="ts">
import { Vue } from "vue-class-component";
import { serverURL } from "@/constants";

export default class Table extends Vue {
  private emailRecords = [];

  async mounted(): Promise<void> {
    try {
      const { data: data } = await this.axios.get(`${serverURL}/emails.php`);
      if (Object.prototype.hasOwnProperty.call(data, "records")) {
        this.emailRecords = data.records;
      }
    } catch (error) {
      console.log(error);
    }
  }
}
</script>

<style lang="scss"></style>
