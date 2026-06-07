<div>
    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Name <span class="text-rose-500">*</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $user?->name) }}" required
           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
    @error('name') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
</div>

<div>
    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-rose-500">*</span></label>
    <input type="email" name="email" id="email" value="{{ old('email', $user?->email) }}" required
           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
    @error('email') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password {{ $user ? '' : '*' }}</label>
        <input type="password" name="password" id="password" {{ $user ? '' : 'required' }}
               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
        @if ($user)
            <p class="mt-1 text-xs text-slate-400">Leave blank to keep current password.</p>
        @endif
        @error('password') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" {{ $user ? '' : 'required' }}
               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Role <span class="text-rose-500">*</span></label>
        <select name="role" id="role" required data-placeholder="Select role"
                class="js-enhanced-select w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
            @foreach ($roles as $role)
                <option value="{{ $role->name }}" @selected(old('role', $user?->role ?? config('cpital.default_role_name')) === $role->name)>
                    {{ ucfirst($role->name) }}
                </option>
            @endforeach
        </select>
        @error('role') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="department_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Department <span class="text-rose-500">*</span></label>
        <select name="department_id" id="department_id" required data-placeholder="Select department"
                class="js-enhanced-select w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
            @foreach ($departments as $dept)
                <option value="{{ $dept->id }}" @selected(old('department_id', $user?->department_id ?? config('cpital.default_department_code')) == $dept->id)>
                    {{ $dept->name }} ({{ $dept->code }})
                </option>
            @endforeach
        </select>
        @error('department_id') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
    </div>
</div>

<div class="flex items-center">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active" value="1"
           @checked(old('is_active', $user?->is_active ?? true))
           class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500">
    <label for="is_active" class="ml-2.5 text-sm font-medium text-slate-600">Active</label>
</div>
