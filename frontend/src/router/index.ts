import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import { baseURL } from "@/constants";
import FrontPage from "@templates/FrontPage.vue";
import Table from "@templates/Table.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "Home",
    component: FrontPage,
  },
  {
    path: "/table",
    name: "Table",
    component: Table,
  },
];

const router = createRouter({
  history: createWebHistory(baseURL),
  routes,
});

export default router;
