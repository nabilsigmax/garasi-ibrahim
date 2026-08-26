@php $prefix = isset($isEdit) && $isEdit ? 'edit_' : ''; @endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left">
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Mobil</label>
        <input type="text" id="{{ $prefix }}name" name="name" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Merek (Brand)</label>
        <input type="text" id="{{ $prefix }}brand" name="brand" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori</label>
        <input type="text" id="{{ $prefix }}category" name="category" placeholder="Contoh: Luxury Sedan" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Harga (Rp)</label>
        <input type="number" id="{{ $prefix }}price" name="price" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Badge Label (Opsional)</label>
        <input type="text" id="{{ $prefix }}badge" name="badge" placeholder="Contoh: TERLAKU / BARU" class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Warna Badge (Class Tailwind)</label>
        <input type="text" id="{{ $prefix }}badge_color" name="badge_color" value="bg-gray-800" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Tahun</label>
        <input type="number" id="{{ $prefix }}year" name="year" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Transmisi</label>
        <select id="{{ $prefix }}transmission" name="transmission" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
            <option value="Automatic">Automatic</option>
            <option value="Manual">Manual</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Bahan Bakar</label>
        <input type="text" id="{{ $prefix }}fuel" name="fuel" placeholder="Contoh: Petrol / Diesel" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Jarak Tempuh (KM)</label>
        <input type="number" id="{{ $prefix }}mileage" name="mileage" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div class="sm:col-span-2">
        <label class="block text-xs font-semibold text-gray-700 mb-1">URL Gambar / Base64</label>
        <input type="text" id="{{ $prefix }}image" name="image" required class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div class="sm:col-span-2">
        <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi</label>
        <textarea id="{{ $prefix }}description" name="description" rows="3" class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
    </div>
</div>