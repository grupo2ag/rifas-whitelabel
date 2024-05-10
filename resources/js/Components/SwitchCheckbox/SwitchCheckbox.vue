<template>
    <div class="flex items-center gap-2">
        <div class="c-checkbox z-0">
            <input type="checkbox" :id="id" @input="$emit('update:modelValue', $event.target.checked)"
                :checked="modelValue">
            <label class="c-checkbox" :for="id">
                <div class="check">
                    <span></span>
                </div>
            </label>
        </div>

        <template v-if="label">
            <label :for="id" v-if="side == 'left'" class="c-checkbox__label">
                {{ label }}
            </label>
        </template>

        <template v-if="label">
            <label :for="id" v-if="side == 'right'" class="c-checkbox__label">
                {{ label }}
            </label>
        </template>
    </div>
</template>

<script>
export default {
    name: "SwitchCheckbox",
    emits: ['update:modelValue'],
    props: ['label', 'modelValue', 'side', 'id']
}
</script>

<style lang="scss">
.c-checkbox {
    //width: 100%;
    display: flex;
    gap: 5px;
    position: relative;

    label {
        cursor: pointer;
        display: flex;
        align-items: center;

        .check {
            width: 36px;
            height: 20px;
            @apply bg-base-300 rounded-full;
            //border: 1px solid #ddd; position: relative;
            display: table;
            cursor: pointer;

            span {
                width: 14px;
                height: 14px;
                cursor: pointer;
                position: absolute;
                top: 50%;
                left: 4px;
                transform: translateY(-50%);
                z-index: 1;
                @apply bg-content rounded-full flex;
                transition: all 0.4s ease;
                box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.3);
            }
        }

        p {
            width: calc(100% - 53px);
            padding-left: 13px;
            text-align: justify;
            line-height: 14px;
        }
    }

    &__label{
        @apply text-sm text-neutral whitespace-nowrap cursor-pointer;
    }

    input[type=checkbox] {
        visibility: hidden;
        position: absolute;

        &:checked+label {

            .check {
                @apply bg-success;
                //border-color: $color-primary;

                span {
                    left: 18px;
                    @apply bg-success-bw;
                }
            }
        }
    }
}
</style>
