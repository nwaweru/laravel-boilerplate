<div class="row">
    @foreach ($permissionGroups as $group)
        @if ($group->permissions->count())
            <div class="col-md-6">
                @foreach ($group->permissions as $permission)
                    <div class="form-check mx-3">
                        <label class="form-check-label">
                            <input type="checkbox"
                                   id="permission-{{ $permission->uuid }}"
                                   value="{{ $permission->id }}"
                                   class="form-check-input"
                                   {{ (old('permissions') && in_array($permission->id, old('permissions')) || in_array($permission->id, $currentPermissions)) ? 'checked' : null }}
                                   disabled>
                            {{ $permission->display_name }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
</div>
