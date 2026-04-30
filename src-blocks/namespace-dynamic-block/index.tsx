import { registerBlockType } from "@wordpress/blocks";
import metadata from './block.json';
import Logo from "../custom-logo";
import React from "react";
import Edit from "./edit";
import './style.css';

registerBlockType(
    // @ts-ignore
    metadata,
    {
        icon: {
            src: <Logo/>
        },
        edit: Edit
    }
)