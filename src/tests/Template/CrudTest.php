<?php

namespace {{ namespace }};

use App\Enums\Users\RoleEnum;
use App\Models\{{ class }};

use App\Models\User as AuthModel;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class {{ class }}Test extends TestCase
{
    /**
     * TESTS GUEST CANNOT ACCESS ROUTES
     */

    /** @return void */
    public function testGuestCannotAccess{{ class }}sIndex(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                '{{ snakeCaseClass }}s.' .
                config('unit-tests.view.resources-index')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccess{{ class }}sShow(): void
    {
        $model    = {{ class }}::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                '{{ snakeCaseClass }}s.' .
                config('unit-tests.view.resources-read'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccess{{ class }}sCreate(): void
    {
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                '{{ snakeCaseClass }}s.' .
                config('unit-tests.view.resources-create')
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotAccess{{ class }}sEdit(): void
    {
        $model    = {{ class }}::factory()->createOneQuietly();
        $response = $this->get(route(
            config('unit-tests.route.prefix') .
                '{{ snakeCaseClass }}s.' .
                config('unit-tests.view.resources-update'),
            $model->getKey()
        ));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS GUEST CANNOT USE ROUTES.
     */

    /** @return void */
    public function testGuestCannotCreate{{ class }}(): void
    {
        $model    = {{ class }}::factory()->createOneQuietly();
        $response = $this->post(
            route(
                config('unit-tests.route.prefix') . '{{ snakeCaseClass }}s.' . config('unit-tests.route.action-create'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotEdit{{ class }}(): void
    {
        $model    = {{ class }}::factory()->createOneQuietly();
        $response = $this->patch(
            route(
                config('unit-tests.route.prefix') . '{{ snakeCaseClass }}s.' . config('unit-tests.route.action-update'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testGuestCannotDestroy{{ class }}(): void
    {
        $model    = {{ class }}::factory()->createOneQuietly();
        $response = $this->delete(
            route(
                config('unit-tests.route.prefix') . '{{ snakeCaseClass }}s.' . config('unit-tests.route.action-delete'),
                $model->getKey()
            ),
            $model->toArray()
        );
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /**
     * TESTS CONCEPTOR USER ACCESS ROUTES.
     */

    /** @return void */
    public function testUserConceptorCanAccess{{ class }}sIndexView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . '{{ snakeCaseClass }}s.' . config('unit-tests.view.resources-index'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.{{ snakeCaseClass }}s.' .
                config('unit-tests.view.resources-index')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccess{{ class }}sReadView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $model    = {{ class }}::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . '{{ snakeCaseClass }}s.' . config('unit-tests.view.resources-read'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.{{ snakeCaseClass }}s.' .
                config('unit-tests.view.resources-read')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccess{{ class }}sCreateView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . '{{ snakeCaseClass }}s.' . config('unit-tests.view.resources-create'))
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.{{ snakeCaseClass }}s.' .
                config('unit-tests.view.resources-create')
        );
    }

    /** @return void */
    public function testUserConceptorCanAccess{{ class }}sEditView(): void
    {
        $authModel = AuthModel::factory()->createOneQuietly();
        $authModel->update(['role' => RoleEnum::conceptor]);
        $model    = {{ class }}::factory()->createOneQuietly();
        $response = $this->actingAs($authModel, 'backend')->get(
            route(config('unit-tests.route.prefix') . '{{ snakeCaseClass }}s.' . config('unit-tests.view.resources-update'), $model)
        );
        $response->assertSuccessful();
        $response->assertViewIs(
            config('unit-tests.view.prefix') .
                'pages.{{ snakeCaseClass }}s.' .
                config('unit-tests.view.resources-update')
        );
    }

    /**
     * TESTS CAN FUNCTIONNALITIES.
     */

    /** @return void */
    public function testCanCreate{{ class }}(): void
    {
        ${{ camelCaseClass }}Created = {{ class }}::factory()->createOneQuietly();
        $this->assertModelExists(${{ camelCaseClass }}Created);
    }

    /** @return void */
    public function testCanUpdate{{ class }}(): void
    {
        ${{ camelCaseClass }} = {{ class }}::factory()->createOneQuietly();

        $fieldTest = "";
        foreach (config('unit-tests.list-fields') as $field) {
            if (Schema::hasColumn(${{ camelCaseClass }}->getTable(), $field)) {
                ${{ camelCaseClass }}->update([$field => "test"]);
                $fieldTest = $field;
                break;
            }
        }

        $this->assertTrue(${{ camelCaseClass }}->wasChanged());
        $this->assertTrue(array_key_exists($fieldTest, ${{ camelCaseClass }}->getChanges()));
        $this->assertModelExists(${{ camelCaseClass }});
    }

    /** @return void */
    public function testCanDestroy{{ class }}(): void
    {
        ${{ camelCaseClass }}Deleted = {{ class }}::factory()->createOneQuietly();
        ${{ camelCaseClass }}Deleted->delete();
        $this->assertModelMissing(${{ camelCaseClass }}Deleted);
    }
}
