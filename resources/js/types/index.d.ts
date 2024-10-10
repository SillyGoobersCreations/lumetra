import {User} from "@/types/models/User";
import {Attendee} from "@/types/models/Attendee";

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        attendees: Attendee[];
    };
};
