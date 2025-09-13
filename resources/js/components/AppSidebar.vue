<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, LineChart,ShoppingCart,Users,DollarSign} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '#', // No queremos navegar
        icon: LineChart,
        onClick: () => {
            alert('Este módulo se está trabajando');
        }
    },
    {
        title: 'Productos',
        href: '/productos',
        icon: ShoppingCart,
    },
    {
        title: 'Empleados',
        href: '/empleados',
        icon: Users,
    },
    {
        title: 'Ventas',
        href: '#', // No queremos navegar
        icon: DollarSign,
        onClick: () => {
            alert('Este módulo se está trabajando');
        }
    },
];

const footerNavItems: NavItem[] = [
// {
//     title: 'Github Repo',
//     href: 'https://github.com/laravel/vue-starter-kit',
//     icon: Folder,
// },
// {
//     title: 'Documentation',
//     href: 'https://laravel.com/docs/starter-kits#vue',
//     icon: BookOpen,
// },

];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('productos.vista')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
