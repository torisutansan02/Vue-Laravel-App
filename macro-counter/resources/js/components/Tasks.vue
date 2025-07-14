<template>
  <div class="bg-[lightgray] mt-[2rem] mb-[2rem] pl-[2rem] pr-[2rem] pt-[0.5rem] pb-[0.5rem] rounded-[2rem]">
    <h1 class="bg-[lightyellow] w-[fit-content] p-[1rem] rounded-[0.5rem]">Laravel 12 + Vue 3 Tasks</h1>

    <!-- Form to submit a task -->
    <form @submit.prevent="addTask" class="bg-[lightblue] w-[fit-content] p-[1rem] rounded-[0.5rem]">
      <p>
        Name
        <input v-model="form.title" placeholder="Your name" class="p-[0.5rem] mt-[0.5rem]" />
      </p>
      <p>
        Protein Count
        <input v-model.number="form.protein" type="number" placeholder="Protein" class="p-[0.5rem] mt-[0.5rem]" />
      </p>
      <p>
        Carb Count
        <input v-model.number="form.carbs" type="number" placeholder="Carbs" class="p-[0.5rem] mt-[0.5rem]" />
      </p>
      <p>
        Fat Count
        <input v-model.number="form.fat" type="number" placeholder="Fat" class="p-[0.5rem] mt-[0.5rem]" />
      </p>
      <button type="submit" class="bg-[lightgreen] text-[black] px-[1rem] py-[1rem] cursor-[pointer]">Add Macros</button>
    </form>

    <div v-for="task in calculateMacros" :key="task.id" class="mt-[2rem] mb-[2rem] p-[1rem] bg-[lightblue] w-[fit-content] rounded-[0.5rem]">
      <table class="w-[25rem]">
        <thead>
          <tr class="text-left">
            <th> Name </th>
            <th> Protein </th>
            <th> Carbs </th>
            <th> Fats </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> {{ task.title }} </td>
            <td> {{ task.protein }}g </td>
            <td> {{ task.carbs }}g  </td>
            <td> {{ task.fat }}g </td>
          </tr>
          <tr>
            <td> Ideal (g): </td>
            <td> {{ task.macros.protein }}g </td>
            <td> {{ task.macros.carbs }}g </td>
            <td> {{ task.macros.fat }}g </td>
          </tr>
        </tbody>
      </table>
      <button @click="deleteTask(task.id)" class="p-[0.5rem] mt-[1rem] ml-[1rem] mr-[1rem] bg-[lightcoral] cursor-[pointer]">Delete</button>
      <button @click="editTask(task.id)" class="p-[0.5rem] mt-[1rem] ml-[1rem] mr-[1rem] bg-[orange] cursor-[pointer]">Edit</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
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

const getTaskById = async (id) => {
  try {
    const res = await axios.get(`/api/tasks/${id}`)
    console.log('Single task:', res.data)
    return res.data
  } catch (err) {
    console.error('Get single task failed', err)
  }
}

const addTask = async () => {
  try {
    await axios.post('/api/tasks', form.value)

    // Reset Form
    form.value = {
      title: '',
      protein: 0,
      carbs: 0,
      fat: 0
    }
    // Reload tasks
    await fetchTasks()
  } catch (err) {
    console.error('Submit failed', err)
  }
}

const editTask = async (id) => {
  try {
    await axios.put(`/api/tasks/${id}`, form.value)

    // Reset form
    form.value = {
      title: '',
      protein: 0,
      carbs: 0,
      fat: 0
    }

    // Reload Tasks
    await fetchTasks()
  } catch (err) {
    console.error('Update task failed', err)
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

const calculateMacros = computed(() => {
  return tasks.value.map(task => {
    const total = task.protein + task.carbs + task.fat
    const proteinCount = total * 0.45
    const carbsCount = total * 0.35
    const fatCount = total * 0.20

    return {
      ...task,
      macros: {
        protein: proteinCount.toFixed(1),
        carbs: carbsCount.toFixed(1),
        fat: fatCount.toFixed(1)
      }
    }
  })
})

// Render the tasks after the DOM is loaded
onMounted(() => {
  fetchTasks()
})
</script>

<style scoped>
input {
  display: block;
}
</style>
