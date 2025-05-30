{{-- resources/views/booking/datetime.blade.php --}}
@extends('public.layout')

@section('content')
<div class="pt-28 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" data-aos="fade-up">
  <div class="container mx-auto px-4 lg:px-0 py-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 text-sm text-gray-500" aria-label="Breadcrumb" data-aos="fade-down">
      <ol class="flex items-center space-x-2">
        <li>
          <a href="{{ route('public.home') }}" class="hover:text-gray-700 transition">
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10.707 2.293a1 1 0…"/>
            </svg>
            Home
          </a>
        </li>
        <li>›</li>
        <li class="text-gray-700 font-medium">Step 4: Date & Time</li>
      </ol>
    </nav>

    {{-- Stepper --}}
    <div class="mb-10" data-aos="fade-down" data-aos-delay="100">
      <div class="flex items-center justify-center space-x-4">
        {{-- Steps 1–3 Completed --}}
        @foreach([1,2,3] as $n)
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">
              ✓
            </div>
            <span class="text-blue-600">{{ ["Service","Vehicle","Extras"][$n-1] }}</span>
          </div>
          <div class="flex-1 h-px bg-gray-300"></div>
        @endforeach

        {{-- Step 4 Active --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
            4
          </div>
          <span class="text-blue-600 font-semibold">Date & Time</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        {{-- Step 5–6 Pending --}}
        @foreach([5,6] as $n)
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
              {{ $n }}
            </div>
            <span class="text-gray-500">{{ ["Your Info","Confirm"][$n-5] }}</span>
          </div>
          @if($n < 6)
            <div class="flex-1 h-px bg-gray-300"></div>
          @endif
        @endforeach
      </div>
    </div>

    {{-- Main grid: calendar + summary --}}
    <div class="grid lg:grid-cols-3 gap-8">

      {{-- Calendar & Slots --}}
      <main class="lg:col-span-2 bg-white rounded-2xl shadow p-6" data-aos="fade-right" data-aos-delay="200">
        {{-- Month navigation --}}
        <div class="flex items-center justify-between mb-4">
          <button id="prev-month" class="p-2 rounded hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </button>
          <h2 id="calendar-month" class="text-lg font-semibold"></h2>
          <button id="next-month" class="p-2 rounded hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>

        {{-- Weekday headers --}}
        <div class="grid grid-cols-7 text-center text-sm text-gray-500 mb-2">
          <div>Mon</div><div>Tue</div><div>Wed</div>
          <div>Thu</div><div>Fri</div><div>Sat</div><div>Sun</div>
        </div>

        {{-- Date grid --}}
        <div id="calendar-grid" class="grid grid-cols-7 gap-1 mb-6"></div>

        {{-- Time slot sections --}}
        <div class="space-y-6">
          <div>
            <h3 class="font-semibold mb-2">Morning</h3>
            <div id="morning-slots" class="grid grid-cols-4 gap-2"></div>
          </div>
          <div>
            <h3 class="font-semibold mb-2">Afternoon</h3>
            <div id="afternoon-slots" class="grid grid-cols-4 gap-2"></div>
          </div>
        </div>
      </main>

      {{-- Summary Sidebar --}}
      <aside class="bg-white rounded-2xl shadow p-6 sticky top-28" data-aos="fade-left" data-aos-delay="300">
        <h3 class="text-xl font-semibold mb-4">Appointment Summary</h3>
        <p><strong>Service:</strong> {{ $service->name }}</p>
        <p><strong>Vehicle:</strong> {{ $vehicle->vehicleType->name }} — ${{ number_format($vehicle->price,2) }}</p>
        <p><strong>Extras:</strong>
          @if($extras->isEmpty()) None
          @else {{ $extras->pluck('name')->join(', ') }}
          @endif
        </p>
        <p><strong>Date:</strong> <span id="summary-date">Not selected</span></p>
        <p><strong>Time:</strong> <span id="summary-time">Not selected</span></p>
        <p class="mt-4 text-lg font-semibold">
          Total: ${{ number_format($vehicle->price + $extras->sum('price'),2) }}
        </p>

        <form id="datetime-form" method="POST" action="{{ route('booking.datetime.store') }}" class="mt-6">
          @csrf
          <input type="hidden" name="appointment_date" id="input-date" value="{{ session('booking.appointment_date') }}">
          <input type="hidden" name="appointment_time" id="input-time" value="{{ session('booking.appointment_time') }}">
          <div class="flex gap-4">
            <a href="{{ route('booking.extras') }}"
               class="flex-1 px-4 py-2 bg-white border rounded-lg text-center hover:bg-gray-100">
              &larr; Back
            </a>
            <button id="next-btn" type="submit"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg disabled:opacity-50"
                    disabled>
              Next
            </button>
          </div>
        </form>
      </aside>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const blocked = @json($blockedAppointments);
    let current = new Date();
    const monthEl = document.getElementById('calendar-month');
    const gridEl = document.getElementById('calendar-grid');
    const summaryDate = document.getElementById('summary-date');
    const summaryTime = document.getElementById('summary-time');
    const inputDate = document.getElementById('input-date');
    const inputTime = document.getElementById('input-time');
    const nextBtn = document.getElementById('next-btn');
    const slotsConfig = { morning: [8,9,10,11], afternoon: [12,13,14,15,16,17] };

    function renderCalendar(date) {
      // Fecha de hoy a medianoche
      const todayMidnight = new Date();
      todayMidnight.setHours(0,0,0,0);

      const year = date.getFullYear(), month = date.getMonth();
      monthEl.textContent = date.toLocaleString('default',{ month:'long', year:'numeric' });
      gridEl.innerHTML = '';

      // Espacios hasta el primer día de la semana
      const firstDay = (new Date(year, month, 1).getDay() + 6) % 7;
      for(let i=0; i<firstDay; i++) {
        gridEl.appendChild(document.createElement('div'));
      }

      // Botones de cada día
      for(let d=1, days=new Date(year, month+1, 0).getDate(); d<=days; d++){
        const btn = document.createElement('button');
        btn.textContent = d;
        btn.className = 'py-2 rounded hover:bg-blue-100';

        // Construye la fecha a medianoche local
        const cellDate = new Date(year, month, d);
        cellDate.setHours(0,0,0,0);

        // ¿Día completo bloqueado?
        const iso = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const dayBlocked = blocked.filter(b=>b.date===iso).length
                         >= slotsConfig.morning.length + slotsConfig.afternoon.length;

        if (cellDate < todayMidnight || dayBlocked) {
          btn.disabled = true;
          btn.classList.add('opacity-50','cursor-not-allowed');
        } else {
          btn.addEventListener('click', ()=> {
            // marca día seleccionado
            gridEl.querySelectorAll('button').forEach(b=>b.classList.remove('bg-blue-200'));
            btn.classList.add('bg-blue-200');
            inputDate.value = iso;
            summaryDate.textContent = date.toLocaleDateString('en-US',{
              weekday:'short', month:'short', day:'numeric'
            });
            renderSlots(iso);
            checkNext();
          });
        }

        gridEl.appendChild(btn);
      }
    }

    function renderSlots(dateStr) {
      ['morning','afternoon'].forEach(section=>{
        const cont = document.getElementById(section+'-slots');
        cont.innerHTML = '';
        slotsConfig[section].forEach(hour=>{
          // omite horas ya reservadas
          if (blocked.some(b=>b.date===dateStr && b.hour===`${String(hour).padStart(2,'0')}:00`)) return;
          const btn = document.createElement('button');
          const ampm = hour<12?'AM':'PM', hr12 = hour%12||12;
          btn.textContent = `${hr12}:00 ${ampm}`;
          btn.className = 'px-3 py-2 rounded hover:bg-blue-100';

          // sólo bloquea horas pasadas
          const slotTime = new Date(`${dateStr}T${String(hour).padStart(2,'0')}:00`);
          if (slotTime < new Date()) return;

          btn.addEventListener('click', ()=>{
            cont.querySelectorAll('button').forEach(b=>b.classList.remove('bg-blue-200'));
            btn.classList.add('bg-blue-200');
            inputTime.value = `${String(hour).padStart(2,'0')}:00`;
            summaryTime.textContent = btn.textContent;
            checkNext();
          });
          cont.appendChild(btn);
        });
      });
    }

    function checkNext() {
      nextBtn.disabled = !(inputDate.value && inputTime.value);
    }

    document.getElementById('prev-month').onclick = ()=> {
      current.setMonth(current.getMonth()-1);
      renderCalendar(current);
    };
    document.getElementById('next-month').onclick = ()=> {
      current.setMonth(current.getMonth()+1);
      renderCalendar(current);
    };

    renderCalendar(current);
  });
</script>

@endsection