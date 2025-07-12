<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Laravel 12 + Vue 3 Tasks</h1>

    <form @submit.prevent="addTask" class="space-y-2">
      <input v-model="form.title" placeholder="Task title" class="border p-1 w-full" />
      <input v-model.number="form.protein" type="number" placeholder="Protein" class="border p-1 w-full" />
      <input v-model.number="form.carbs" type="number" placeholder="Carbs" class="border p-1 w-full" />
      <input v-model.number="form.fat" type="number" placeholder="Fat" class="border p-1 w-full" />
      <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Add Task</button>
    </form>

    <ul class="mt-6 space-y-2">
      <li v-for="task in tasks" :key="task.id" class="border p-2">
        {{ task.title }} - P: {{ task.protein }}, C: {{ task.carbs }}, F: {{ task.fat }}
        <button @click="deleteTask(task.id)" class="ml-4 text-red-600">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const tasks = ref([])
const form = ref({
  title: '',
  protein: 0,
  carbs: 0,
  fat: 0
})

const fetchTasks = async () => {
  try {
    const res = await axios.get('/api/tasks')
    tasks.value = res.data
  } catch (err) {
    console.error('Fetch failed', err)
  }
}

const addTask = async () => {
  try {
    await axios.post('/api/tasks', form.value)
    await fetchTasks()
    form.value = { title: '', protein: 0, carbs: 0, fat: 0 }
  } catch (err) {
    console.error('Add failed', err)
  }
}

const deleteTask = async (id) => {
  try {
    await axios.delete(`/api/tasks/${id}`)
    await fetchTasks()
  } catch (err) {
    console.error('Delete failed', err)
  }
}

onMounted(fetchTasks)
</script>

<style scoped>
input {
  display: block;
}
</style>
