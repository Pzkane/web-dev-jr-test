<template>
  <div class="wrapper">
    <div class="container">
      <div>
        <table>
          <thead>
            <tr>
              <th>
                <input
                  type="checkbox"
                  v-model="allCheck"
                  @change="registerEmailId($event)"
                />
              </th>
              <th @click="sortIDs">
                ID
                {{ params.orderByColumn === "id" ? sortSymbol : null }}
              </th>
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
              <th>
                <input
                  type="checkbox"
                  :checked="record.checked"
                  @change="registerEmailId($event, record.id)"
                />
              </th>
              <th>{{ record.id }}</th>
              <th>{{ record.email }}</th>
              <th>{{ record.created_at }}</th>
              <th @click="deleteRecord(record.id)" class="del-label"></th>
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
          <div v-if="checkedEmails.length">
            <button @click="exportEmails">Export e-mails</button>
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
        @domain="filterByDomains"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from "vue-class-component";
import { serverURL } from "@/constants";
import { OptionType } from "@/components/molecules/LabeledSelect.vue";
import LabeledSelect from "@/components/molecules/LabeledSelect.vue";

interface EmailType {
  id: number;
  emails: string;
  domain: string;
  created_at: Date;
  checked: boolean;
}

interface ParamsProps {
  type: string;
  orderByColumn?: string | null;
  orderBy?: string | null;
  offset: number;
  pagination: number;
  domain?: string;
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
  private emailRecords: EmailType[] = [];
  private pagination = 10;
  private sEmail = 0;
  private sTime = 0;
  private sID = 0;
  private params: ParamsProps = {
    type: "records",
    orderByColumn: "created_at",
    orderBy: "asc",
    offset: 0,
    pagination: this.pagination,
  };
  private sortSymbol = "";
  private checkedEmails: number[] = [];
  private allCheck = false;
  private checks = 0;

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
          this.params.offset ? (this.params.offset -= this.pagination) : null;
        }
      } else if (Object.prototype.hasOwnProperty.call(data, "domains")) {
        if (data.domains.length) {
          for (const domain of data.domains) {
            this.domains.push({
              value: domain,
              label:
                domain.slice(0, 1) +
                domain.charAt(1).toUpperCase() +
                domain.slice(2),
            });
          }
        }
      }
      this.assignChecks();
    } catch (error) {
      console.log(error);
    }
  }

  public async deleteRecord(id: number): Promise<void> {
    try {
      await this.axios.delete(`${serverURL}/emails`, { params: { id } });
      this.fetchEmails(this.params);
      if (this.emailRecords) this.fetchEmails(this.params);
    } catch (error) {
      console.log(error);
    }
  }

  public async exportEmails(): Promise<void> {
    try {
      let fData = new FormData();
      fData.append("email_ids", JSON.stringify(this.checkedEmails));
      const { data: resultCSV } = await this.axios.post(
        `${serverURL}/emails`,
        fData
      );
      let blob = new Blob([resultCSV], { type: "application/csv" });
      let link = document.createElement("a");
      link.href = window.URL.createObjectURL(blob);
      link.download = "email_export.csv";
      link.click();
      link.remove();

      this.checkedEmails = [];
      this.emailRecords.map((email) => (email.checked = false));
      this.allCheck = false;
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

  public sortIDs(): void {
    this.params.orderByColumn = "id";
    this.params.offset = 0;
    this.sEmail = 0;
    this.sTime = 0;

    this.setSortSymbol(this.sID);
    switch (this.sID) {
      case 0:
        this.params.orderBy = "desc";
        ++this.sID;
        break;

      case 1:
        this.params.orderBy = "asc";
        ++this.sID;
        break;

      case 2:
        this.params.orderByColumn = "created_at";
        this.params.orderBy = "asc";
        this.sID = 0;
        break;
    }
    this.fetchEmails(this.params);
  }

  public sortEmails(): void {
    this.params.orderByColumn = "email";
    this.params.offset = 0;
    this.sTime = 0;
    this.sID = 0;

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
        this.params.orderByColumn = "created_at";
        this.params.orderBy = "asc";
        this.sEmail = 0;
        break;
    }
    this.fetchEmails(this.params);
  }

  public sortTime(): void {
    this.params.orderByColumn = "created_at";
    this.params.offset = 0;
    this.sEmail = 0;
    this.sID = 0;

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
        this.params.orderByColumn = "created_at";
        this.params.orderBy = "asc";
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

  public assignChecks(): void {
    this.checks = 0;
    this.checkedEmails.map((emId) => {
      let record = this.emailRecords.find((em) => em.id === emId);
      if (record) {
        record.checked = true;
        ++this.checks;
      }
    });
    this.determineAllCheck();
  }

  public filterByDomains(domain: string): void {
    this.params.offset = 0;
    this.params.domain = domain;
    this.fetchEmails(this.params);
  }

  public registerEmailId(e: Event, id: number | undefined): void {
    const checked = (e.target as HTMLInputElement).checked;
    if (!id) {
      if (checked)
        this.emailRecords.map((email) => {
          email.checked = true;
          this.checkedEmails.push(email.id);
          ++this.checks;
        });
      else {
        const ids = this.emailRecords.map((email) => email.id);
        this.checkedEmails = this.checkedEmails.filter((emId) => {
          return !ids.includes(emId);
        });
        this.emailRecords.map((email) => {
          email.checked = false;
          --this.checks;
        });
      }
    } else {
      if (checked) {
        this.checkedEmails.push(id);
        ++this.checks;
      } else {
        this.checkedEmails = this.checkedEmails.filter((emId) => emId !== id);
        --this.checks;
      }
      this.determineAllCheck();
    }
  }

  public determineAllCheck(): void {
    this.checks === this.emailRecords.length
      ? (this.allCheck = true)
      : (this.allCheck = false);
  }
}
</script>

<style scoped lang="scss">
.del-label {
  width: 30px;
  background-color: white;
}
.table-controls {
  display: flex;
  justify-content: space-between;
  & > div {
    &:last-child {
      float: right;
      margin-right: 35px;
    }
  }
}
.container {
  max-width: 80%;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 75% 25%;

  & input {
    max-width: 50px;
  }
}
.wrapper {
  margin: 40px 0;
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
      &:not(:last-child):hover,
      &:not(:first-child):hover {
        cursor: pointer;
      }

      &:last-child,
      &:first-child {
        background-color: white;
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
