export interface Toy {
    id: number;
    name: string;
    description: string | null;
    image_path: string | null;
    created_at: string;
    updated_at: string;
    child_id: number;
}

export interface ToyForm {
    name: string;
    description: string | null;
    image_path: File | null;
}
