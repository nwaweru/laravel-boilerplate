<div class="row">
    @foreach ($permissionGroups as $group)
        <div class="col-md-6">
            <p>
                <a class="card-link" data-toggle="collapse" href="#permission-group-{{ $group->uuid }}" role="button" aria-expanded="false" aria-controls="permission-group-{{ $group->uuid }}">
                    {{ $group->name }}
                </a>
            </p>
            <div class="collapse show" id="permission-group-{{ $group->uuid }}">
                @foreach ($group->permissions as $permission)
                    <div class="form-check mx-3">
                        <label class="form-check-label">
                            <input type="checkbox" id="permission-{{ $permission->uuid }}" name="permissions[]"
                                value="{{ $permission->id }}" class="form-check-input"
                                {{ (old('permissions') && in_array($permission->id, old('permissions')) || in_array($permission->id, $currentPermissions)) ? 'checked' : null }}
                                disabled>
                            {{ $permission->display_name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
