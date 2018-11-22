import Add from './components/attention/Add'
import Show from './components/attention/Show'
import Edit from './components/attention/Edit'
import Attention from './components/Attention'
import EmployeeSalary from './components/EmployeeSalary'
import PaymentDetails from './components/EmployeeSalary/PaymentDetails'
import Expenses from './components/Expenses'
import AddExpense from './components/AddExpense'
import ManagmentExp from './components/expesnes/ManagmentExp'
import LinkTeachers from './components/LinkTeachers'
import LinkTeacher from './components/links/LinkTeacher'

const router = [
    {
        path: '/admin/link_teachers/:id',
        name: 'linkTeacher',
        components: {"content-viewport" : LinkTeacher},
        props: true
    },
    {
        path: '/admin/link_teachers',
        name: 'linkTeachers',
        components: {"content-viewport" : LinkTeachers},
        props: true
    },
    {
        path: '/admin/expenses/:id',
        name: 'studentExpenses',
        components: {"content-viewport" : ManagmentExp},
        props: true
    },
    {
        path: '/admin/add_expenses',
        name: 'addExpenses',
        components: {"content-viewport" : AddExpense},
        props: true
    },
    {
        path: '/admin/expenses',
        name: 'expenses',
        components: {"content-viewport" : Expenses},
        props: true
    },
    {
        path: '/admin/employee_salaries',
        name: 'salaries',
        components: {"content-viewport" : EmployeeSalary},
        props: true
    },
    {
        path: '/admin/employee_salaries/:id/payment-details',
        name: 'paymentDetails',
        components: {"content-viewport" : PaymentDetails},
        props: true
    },
    {
        path: '/admin/attentions',
        name: 'attentions',
        components: {"content-viewport" : Attention},
        props: true
    },
    {
        path: '/admin/attentions/:id/add',
        name: 'attentionsAdd',
        components: {"content-viewport" : Add},
        props: true
    },
    {
        path: '/admin/attentions/:id/show',
        name: 'attentionsShow',
        components: {"content-viewport" : Show},
        props: true
    },
    {
        path: '/admin/attentions/:id/edit/:edit',
        name: 'attentionsEdit',
        components: {"content-viewport" : Edit},
        props: true
    },
]

export default router