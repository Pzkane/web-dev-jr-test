<template>
  <div class="wrapper">
    <div class="container">
      <div>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th @click="sortEmails">
                E-mail
                {{ params.orderByColumn === "email" ? sortSymbol : null }}
              </th>
              <th @click="sortTime">
                Subscribed At
                {{ params.orderByColumn === "created_at" ? sortSymbol : null }}
              </th>
              <th class="del-label"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="record in emailRecords" :key="record.id">
              <th>{{ record.id }}</th>
              <th>{{ record.email }}</th>
              <th>{{ record.created_at }}</th>
              <th class="del-label"></th>
            </tr>
          </tbody>
        </table>
        <div class="table-controls">
          <div>
            <label for="pagination">Per Page:</label>
            <input
              v-model="pagination"
              id="pagination"
              name="pagination"
              type="number"
            />
            <button @click="applyPagination">OK</button>
          </div>
          <div>
            <button @click="prev">&lt;</button>
            <button @click="next">&gt;</button>
          </div>
        </div>
      </div>
      <LabeledSelect
        class="domain-select"
        :header="'Domains'"
        :options="domains"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { serverURL } from "@/constants";
import { OptionType } from "@/components/molecules/LabeledSelect.vue";
import LabeledSelect from "@/components/molecules/LabeledSelect.vue";

interface ParamsProps {
  type: string;
  orderByColumn?: string | null;
  orderBy?: string | null;
  offset: number;
  pagination: number;
}

interface ParamsPropsTypeOnly {
  type: string;
}

type ParamsType = ParamsProps | ParamsPropsTypeOnly;

@Options({
  components: {
    LabeledSelect,
  },
})
export default class Table extends Vue {
  private domains: OptionType[] = [];
  private emailRecords = [];
  private pagination = 10;
  private sEmail = 0;
  private sTime = 0;
  private params: ParamsProps = {
    type: "records",
    offset: 0,
    pagination: this.pagination,
  };
  private sortSymbol = "";

  async mounted(): Promise<void> {
    const params: ParamsPropsTypeOnly = {
      type: "domains",
    };
    this.fetchEmails(params);
    this.fetchEmails(this.params);
  }

  public async fetchEmails(
    params: ParamsType | undefined = undefined
  ): Promise<void> {
    try {
      const { data: data } = await this.axios.get(`${serverURL}/emails.php`, {
        params,
      });
      if (Object.prototype.hasOwnProperty.call(data, "records")) {
        if (data.records.length) this.emailRecords = data.records;
        else {
          this.params.offset
            ? (this.params.offset -= 2 * this.pagination)
            : null;
        }
      } else if (Object.prototype.hasOwnProperty.call(data, "domains")) {
        if (data.domains.length) {
          for (const domain of data.domains) {
            this.domains.push({
              value: domain,
              label: domain.charAt(0).toUpperCase() + domain.slice(1),
            });
          }
        }
      }
    } catch (error) {
      console.log(error);
    }
  }

  public setSortSymbol(iter: number): void {
    switch (iter) {
      case 0:
        this.sortSymbol = "↓";
        break;

      case 1:
        this.sortSymbol = "↑";
        break;

      case 2:
        this.sortSymbol = "";
        break;

      default:
        console.log("Not defined");
        break;
    }
  }

  public sortEmails(): void {
    this.params.orderByColumn = "email";
    this.params.offset = 0;
    this.sTime = 0;

    this.setSortSymbol(this.sEmail);
    switch (this.sEmail) {
      case 0:
        this.params.orderBy = "desc";
        ++this.sEmail;
        break;

      case 1:
        this.params.orderBy = "asc";
        ++this.sEmail;
        break;

      case 2:
        this.params.orderByColumn = null;
        this.params.orderBy = null;
        this.sEmail = 0;
        break;
    }
    this.fetchEmails(this.params);
  }

  public sortTime(): void {
    this.params.orderByColumn = "created_at";
    this.params.offset = 0;
    this.sEmail = 0;

    this.setSortSymbol(this.sTime);
    switch (this.sTime) {
      case 0:
        this.params.orderBy = "desc";
        ++this.sTime;
        break;

      case 1:
        this.params.orderBy = "asc";
        ++this.sTime;
        break;

      case 2:
        this.params.orderByColumn = null;
        this.params.orderBy = null;
        this.sTime = 0;
        break;
    }
    this.fetchEmails(this.params);
  }

  public applyPagination(): void {
    this.params.pagination = this.pagination;
    this.params.offset = 0;
    this.fetchEmails(this.params);
  }

  public next(): void {
    if (this.params.offset)
      this.params.offset = +this.params.offset + +this.params.pagination;
    else this.params.offset = this.params.pagination;
    this.fetchEmails(this.params);
  }

  public prev(): void {
    if (!this.params.offset) return;
    this.params.offset
      ? (this.params.offset -= this.params.pagination)
      : (this.params.offset = this.params.pagination);
    this.fetchEmails(this.params);
  }
}
</script>

<style scoped lang="scss">
.del-label {
  width: 30px;
  background-color: white;
}
.table-controls {
  & > div {
    display: inline-block;
    &:last-child {
      float: right;
      margin-right: 35px;
    }
  }
}
.container {
  max-width: 60%;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 75% 25%;

  & input {
    max-width: 50px;
  }
}
.wrapper {
  height: 100vh;
  & > * {
    width: 100%;
  }
}
table {
  width: 100%;
  margin: 0 auto;
  align-self: center;
}
thead {
  & tr {
    background-color: #bbe4f9;
    & th {
      &:not(:last-child):hover {
        cursor: pointer;
      }
    }
  }
}
tbody {
  & tr {
    background-color: #e6e7f1;
    &:nth-child(even) {
      background-color: white;
    }
    &:hover {
      background-color: #b8c2d4;
      & th:last-child {
        background-color: inherit;
        background-image: url("~@assets/delete.png");
        background-repeat: no-repeat;
        background-position: center;
        cursor: pointer;
      }
    }
  }
}
</style>
