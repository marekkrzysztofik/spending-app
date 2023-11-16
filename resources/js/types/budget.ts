export interface Budget {
    id: number;
    name: string;
    description: string;
    start_date: Date;
    end_date: Date;
    amount: number;
    limit: number;
    type: string;
    categories_sum_category_limit: number;
    transactions_sum_amount: number;
}